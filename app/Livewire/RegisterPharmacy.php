<?php

namespace App\Livewire;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Stancl\Tenancy\Database\Models\Domain;

class RegisterPharmacy extends Component
{
    public string $pharmacyName = '';

    public string $ownerName = '';

    public string $email = '';

    public string $phone = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public ?string $message = null;

    public string $messageType = 'info';

    public ?string $generatedSlug = null;

    public ?string $generatedDomain = null;

    public ?string $generatedDatabase = null;

    public function register(): void
    {
        $validated = $this->validate([
            'pharmacyName' => ['required', 'string', 'max:150'],
            'ownerName' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'same:passwordConfirmation'],
            'passwordConfirmation' => ['required', 'string', 'min:8'],
        ], [
            'pharmacyName.required' => 'Escribe el nombre de la farmacia.',
            'ownerName.required' => 'Escribe el nombre del administrador.',
            'email.required' => 'Escribe el correo.',
            'email.email' => 'El correo no es válido.',
            'password.required' => 'Escribe una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.same' => 'Las contraseñas no coinciden.',
            'passwordConfirmation.required' => 'Confirma la contraseña.',
        ]);

        $tenant = null;

        try {
            $tenantId = (string) Str::uuid();
            $slug = $this->makeUniqueSlug($validated['pharmacyName']);
            $databaseName = $this->buildDatabaseName($tenantId, $slug);
            $domain = $slug . '.localhost';

            /*
             * Al crear el tenant, el TenancyServiceProvider debe ejecutar:
             * CreateDatabase + MigrateDatabase
             */
            $tenant = Tenant::create([
                'id' => $tenantId,
                'tenancy_db_name' => $databaseName,
                'name' => $validated['pharmacyName'],
                'slug' => $slug,
                'owner_name' => $validated['ownerName'],
                'owner_email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'status' => 'active',
            ]);

            $tenant->domains()->create([
                'domain' => $domain,
            ]);

            /*
             * Este bloque se ejecuta dentro de la base de datos tenant.
             */
            $tenant->run(function () use ($validated) {
                User::create([
                    'name' => $validated['ownerName'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'password' => Hash::make($validated['password']),
                    'role' => 'owner',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            });

            $this->generatedSlug = $slug;
            $this->generatedDomain = $domain;
            $this->generatedDatabase = $databaseName;

            $this->messageType = 'success';
            $this->message = 'Farmacia registrada correctamente. Se creó la base de datos y el usuario administrador.';

            $this->reset([
                'pharmacyName',
                'ownerName',
                'email',
                'phone',
                'password',
                'passwordConfirmation',
            ]);
        } catch (\Throwable $e) {
            if (function_exists('tenancy') && tenancy()->initialized) {
                tenancy()->end();
            }

            if ($tenant) {
                try {
                    $tenant->delete();
                } catch (\Throwable $deleteException) {
                    //
                }
            }

            $this->messageType = 'danger';
            $this->message = 'No se pudo registrar la farmacia: ' . $e->getMessage();
        }
    }

    private function makeUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'farmacia';
        }

        $slug = $baseSlug;
        $counter = 2;

        while ($this->slugOrDomainExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugOrDomainExists(string $slug): bool
    {
        $domain = $slug . '.localhost';

        $tenantExists = Tenant::query()
            ->where('data->slug', $slug)
            ->exists();

        $domainExists = Domain::query()
            ->where('domain', $domain)
            ->exists();

        return $tenantExists || $domainExists;
    }

    private function buildDatabaseName(string $tenantId, string $slug): string
    {
        $shortId = substr(str_replace('-', '', $tenantId), 0, 8);

        $safeSlug = str_replace('-', '_', $slug);
        $safeSlug = preg_replace('/[^a-z0-9_]/', '', $safeSlug);

        return 'tenant_' . $shortId . '_' . $safeSlug;
    }

    public function render()
    {
        return view('livewire.register-pharmacy');
    }
}