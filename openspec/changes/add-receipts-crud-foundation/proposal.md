
## Why

The receipt management feature is the core of the expense tracking application, but no functional CRUD exists for receipts or expenses. The existing models, migrations, and controller stubs have inconsistencies (wrong column names, missing `user_id`, incorrect enum references, missing relationships). Without this foundation, users cannot create, view, or manage their receipts, and the AI extraction pipeline has no data layer to operate on.

## What Changes

- Fix the `recu` migration: add `user_id` column, rename status-related column references for consistency
- Fix the `Status` enum: rename to `StatutRecu` with cases `en_attente`, `traite`, `echoue` as specified in the architecture config
- Fix the `Categorie` enum: rename to `CategorieDepense` with cases `alimentaire`, `boissons`, `hygiene`, `entretien`, `autre` as specified
- Add `recus()` hasMany relationship on the `User` model
- Create `StoreRecuRequest` form request with validation rules
- Fix `RecuController`: correct column names (`text_source`, `status`), enum references (`StatutRecu`), relationship name (`depences`), and authorisation scoping to the authenticated user
- Implement `DepenceController` with full resource methods scoped to the authenticated user's receipts
- Create Blade views: `recus/index`, `recus/create`, `recus/show`, `depences/index`, `depences/create`, `depences/edit`
- Register resource routes for `recus` and `depences`
- Add `user_id` foreign key column to the `recu` table via a new migration

## Capabilities

### New Capabilities

- `receipt-crud`: Create, list, view, and delete receipts. Each receipt stores the raw text source submitted by the user.
- `expense-crud`: Create, list, view, edit, and delete individual expense line items scoped to a receipt. Each expense has libelle, quantite, prix_unitaire, and categorie.

### Modified Capabilities

- *(none — no existing specs to modify)*

## Impact

- **Database**: New migration adding `user_id` to `recu` table. Existing `recu` and `depence` migrations stay as-is but model/enum alignment may require a rollback plan.
- **Models**: `User` gets `recus()` relation. `Recu` model casts updated for new `StatutRecu` enum. `Depence` model casts updated for new `CategorieDepense` enum.
- **Enums**: `Status` → `StatutRecu` (3 cases), `Categorie` → `CategorieDepense` (5 cases). All existing enum references updated.
- **Controllers**: `RecuController` fixed and fully implemented. `DepenceController` implemented.
- **Views**: 6 new Blade views under `resources/views/recus/` and `resources/views/depences/`.
- **Routes**: 2 resource route groups added under the `auth` middleware.
