# AGENTS.md

## What this is

Laravel 10 + Filament 3 insurance management app (Bimeh Takayar). Persian/Farsi UI with Jalali dates, RTL layout, and Vazir font. Domain: insurance claims (harms), customers, dependents, contracts, and organizations.

## Key commands

```bash
php artisan serve              # Dev server
php artisan migrate            # Run migrations
php artisan shield:generate    # Regenerate Filament Shield permissions
php artisan filament:upgrade   # Auto-runs on composer update (post hook)
npm run dev                    # Vite dev server
npm run build                  # Build frontend assets
php artisan queue:work         # Process queued jobs (if needed)
```

**No lint, typecheck, or test commands are configured beyond defaults.** Code style: Laravel Pint (`vendor/bin/pint`). Tests: `php artisan test` or `vendor/bin/phpunit` (minimal coverage - mostly ExampleTest).

## Architecture

### Two Filament panels

| Panel | Path | Auth Guard | Access Rule |
|-------|------|-----------|-------------|
| **Admin** | `/admin` | `web` (default) | Email must end with `@bimehtakayar.ir` |
| **Customer** | `/customer` | `customer` (custom) | Separate login page, customer-facing |

- Panel providers: `app/Providers/Filament/AdminPanelProvider.php`, `app/Providers/Filament/CustomerPanelProvider.php`
- Admin panel auto-discovers Resources/Pages/Widgets from `app/Filament/Resources/`, `app/Filament/Pages/`, `app/Filament/Widgets/`
- Customer panel auto-discovers from `app/Filament/Customer/Resources/`, `app/Filament/Customer/Pages/`, `app/Filament/Customer/Widgets/`
- Both panels share the same Vite theme CSS: `resources/css/filament/admin/theme.css`

### Key directories

- `app/Models/` - Eloquent models (Customer, Contract, Organization, Harm, HarmType, Depend, Relation, etc.)
- `app/Filament/Resources/` - Admin CRUD resources (CustomerResource, ContractResource, etc.)
- `app/Filament/Pages/` - Custom admin pages (reports, SMS config, board, etc.)
- `app/Filament/Customer/` - Customer-facing panel (HarmResource, DependResource, chat, password change)
- `app/Exports/` - Maatwebsite Excel export classes
- `app/Imports/` - Maatwebsite Excel import classes (CustomerImport, DependsImport)
- `app/Tables/Columns/` - Custom Filament table columns
- `app/Policies/` - Authorization policies (managed by Filament Shield)

### Permissions & auth

- **Filament Shield** manages roles/permissions. Run `php artisan shield:generate` after adding new resources/pages/widgets.
- Two built-in roles: `super_admin`, `panel_user`
- User model uses `HasRoles` + `HasPanelShield` traits
- Panel access restricted in `User::canAccessPanel()` - only `@bimehtakayar.ir` emails

### Frontend

- **Vite** (no `vite.config.js` - uses Laravel default conventions)
- **Tailwind CSS** with DaisyUI plugin
- **Mary** component library (robsontenorio/mary) - included in Tailwind content paths
- PostCSS with `postcss-nesting` plugin
- Filament theme built from `resources/css/filament/admin/theme.css` + separate `tailwind.config.js`

### Dates & locale

- **Jalali/Persian calendar** throughout: `morilog/jalali` package + `ariaieboy/filament-jalali-datetime`
- Date format: `Y/m/d` (configured in `config/filament-jalali-datetime.php`)
- All Filament DatePicker fields use `->jalali()` modifier
- Currency: IRR (Iranian Rial) via `ariaieboy/filament-currency`

### Exports & imports

- **Maatwebsite Excel** (`maatwebsite/excel`) for data exports/imports
- **pxlrbt/filament-excel** for inline Filament table export actions (ExportBulkAction)
- Export classes in `app/Exports/`, import classes in `app/Imports/`
- Export temp files: `storage/framework/cache/laravel-excel`

### Database

- MySQL (default). DB name in `.env`: `tk`
- Tests configured for array cache/session/mail but **SQLite in-memory is commented out** in `phpunit.xml` - tests use whatever DB `.env` points to
- 20+ migrations covering customers, contracts, organizations, harms, depends, permissions, etc.

## Gotchas

- After adding new Filament Resources/Pages/Widgets, regenerate permissions: `php artisan shield:generate`
- Customer panel login is custom (`CustomerLogin.php`), not the default Filament login
- Both panels share the same Vite theme CSS file - changes affect both panels
- No `.env.testing` exists - test DB config comes from `.env` or `phpunit.xml` env overrides
- `User` model restricts admin panel access by email domain only (`@bimehtakayar.ir`)
- Filament Shield's `discover_all_resources` is **false** - resources must be registered or explicitly discovered
- `contracts` field on User model is cast to `array` (JSON column)
- Exports use Persian headings and Persian status labels (فعال/غیر فعال)
