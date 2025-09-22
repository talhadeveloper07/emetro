<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define permissions based on modules plus new management permissions
        $permissions = [
            'access-records',
            'access-child-sn-reg',
            'access-service-change',
            'access-provisioning',
            'access-order-processing',
            'access-quotation-ordering',
            'access-inventory',
            'access-order-status',
            'access-invoice',
            'access-cloud-services',
            'access-payment-gateway',
            'access-containers',
            'access-sales-marketing',
            'access-videos',
            'access-support',
            'access-administrator',
            'access-upload-documents',
            'access-rma',
            'access-organization',
            'access-customers',
            'access-certification',
            'access-leads',
            'access-sales-agent',
            'access-store',
            'access-payments',
            'access-marketing',
            'access-upload',
            'access-admin',
            'access-registration',
            'access-invoices',
            'manage-roles',
            'manage-organizations',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Define roles and their permissions
        $rolesPermissions = [

            // E-MetroTel Staff Roles
            'Super Admin' => [
                'access-records',
                'access-child-sn-reg',
                'access-service-change',
                'access-provisioning',
                'access-order-processing',
                'access-quotation-ordering',
                'access-inventory',
                'access-order-status',
                'access-invoice',
                'access-cloud-services',
                'access-payment-gateway',
                'access-containers',
                'access-sales-marketing',
                'access-videos',
                'access-support',
                'access-administrator',
                'access-upload-documents',
                'access-rma',
                'access-organization',
                'access-customers',
                'access-certification',
                'access-leads',
                'access-sales-agent',
                'access-store',
                'access-payments',
                'access-marketing',
                'access-upload',
                'access-admin',
                'access-registration',
                'access-invoices',
                'manage-roles',
                'manage-organizations',
            ],
            'Admin' => [
                'access-administrator',
                'access-upload-documents',
                'access-organization',
                'access-quotation-ordering',
                'access-order-status',
                'access-invoice',
                'access-sales-marketing',
                'manage-roles',
                'manage-organizations',
            ],
            // Reseller Organization Roles
            'Customer' => [
                'access-records',
                'access-invoice',
                'access-payment-gateway',
                'access-organization',
                'access-child-sn-reg',
                'access-service-change',
                'access-order-processing',
                'access-order-status',
                'access-cloud-services',
                'access-videos',
                'access-support',
                'access-rma',
                'access-certification',
                'access-provisioning',
                'access-inventory',
                'access-containers',
            ],
            'Indirect Customer' => [
                'access-records',
                'access-provisioning',
                'access-order-status',
                'access-payment-gateway',
                'access-organization',
                'access-customers',
            ],

            'Finance' => [
                'access-invoice',
                'access-payment-gateway',
            ],
            'Sales' => [
                'access-quotation-ordering',
                'access-order-status',
                'access-invoice',
                'access-cloud-services',
                'access-payment-gateway',
                'access-sales-marketing',
                'access-videos',
                'access-support',
                'access-organization',
                'access-customers',
                'access-certification',
                'access-leads',
                'access-sales-agent',
            ],
            'Support' => [
                'access-cloud-services',
                'access-videos',
                'access-support',
                'access-rma',
            ],
            'Distributor' => [
                'access-upload-documents',
                'access-organization',
            ],

            'Sales Agent' => [
                'access-sales-agent',
                'access-leads',
            ],
            // For All Organizations
            'Accounting' => [
                'access-records',
                'access-registration',
                'access-service-change',
                'access-order-status',
                'access-invoices',
                'access-payments',
                'access-marketing',
                'access-upload',
                'access-organization',
                'access-certification',
            ],
            'Logistics' => [
                'access-records',
                'access-registration',
                'access-service-change',
                'access-order-status',
                'access-inventory',
                'access-marketing',
                'access-upload',
                'access-organization',
                'access-certification',
            ],
            'End User' => [
                'access-records',
                'access-registration',
                'access-service-change',
                'access-provisioning',
                'access-order-status',
                'access-invoices',
                'access-marketing',
                'access-support',
                'access-upload',
                'access-organization',
                'access-certification',
            ],

        ];

        // Create roles and assign permissions
        foreach ($rolesPermissions as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Create a sample user and organization for testing
        $user = User::first();
        $role = Role::findByName('Super Admin');
        $user->assignRole($role);
    }
}
