
## Context

The current codebase has scaffolded `Recu` and `Depence` models, migrations, and controller stubs, but they are inconsistent with the project's architecture rules defined in `openspec/config.yaml`. The `recu` table is missing a `user_id` foreign key, enums (`Status`, `Categorie`) don't match the required values (`StatutRecu`, `CategorieDepense`), the `User` model lacks the `recus()` relationship, the `RecuController` references non-existent columns/enums, and no views or routes exist. This change builds the complete CRUD foundation so users can manage their receipts and expenses, and the future AI extraction pipeline has a data layer to write into.

## Goals / Non-Goals

**Goals:**
- Fix the `recu` migration to include `user_id` (via a new migration, not modifying existing ones)
- Align `Recu` model with `StatutRecu` enum (en_attente, traite, echoue) and correct column names
- Align `Depence` model with `CategorieDepense` enum (alimentaire, boissons, hygiene, entretien, autre)
- Add `recus()` hasMany relationship to `User`
- Create `StoreRecuRequest` form request with validation for `text_source`
- Fully implement `RecuController` (index, create, store, show, destroy) with user scoping
- Fully implement `DepenceController` (index, create, store, show, edit, update, destroy) scoped to receipt ownership
- Create Blade views for listing, creating, showing receipts and expenses
- Register resource routes under the `auth` middleware

**Non-Goals:**
- AI extraction pipeline (job, prompt, structured output) — future change
- Editing or updating receipts (status changes will come with AI pipeline)
- Bulk operations, import/export, or search/filter
- Testing — test files can be added in a follow-up

## Decisions

1. **New migration for user_id instead of editing existing migration**
   - Editing `2026_06_11_120248_recu.php` would require a rollback on production-like data. A new migration `add_user_id_to_recu_table` is safer and follows Laravel conventions.

2. **Rename enums by creating new ones, not editing in-place**
   - `Status` → `StatutRecu`, `Categorie` → `CategorieDepense`. Creating new enum files and updating model casts is cleaner than modifying existing enums that might be referenced elsewhere.

3. **DepenceController routes nested under recus**
   - Routes like `/recus/{recu}/depenses/{depence}` ensure expenses are always scoped to their parent receipt. This prevents URL manipulation accessing another user's data when combined with policy checks.

4. **No dedicated policy class — scoping via controller queries**
   - For now, scoping is done via `auth()->user()->recus()->findOrFail(...)` throughout controllers. This is simpler than creating full policies for this foundational change. Policies can be extracted later.

5. **Form Request for receipt creation only**
   - `StoreRecuRequest` validates the receipt text source. Depence creation also gets a `StoreDepenseRequest`. Both keep validation out of controllers.

6. **Blade views use existing app layout**
   - Leverage `layouts/app.blade.php` from Breeze. Views follow the same patterns as `dashboard.blade.php` for consistency.

## Risks / Trade-offs

- **Enum rename may break unknown references**: The `Status` and `Categorie` enums may be imported elsewhere in the codebase (tests, seeders). Mitigation: grep all files before renaming, update all references.
- **Missing user_id on existing records**: After migration, existing `recu` rows will have `user_id = null`. Mitigation: the migration makes `user_id` nullable with a `set null` on delete, so null rows exist but won't break new flows. Can backfill manually.
- **No tests in scope**: CRUD operations are manual to verify until tests are written. Mitigation: manual smoke testing of each endpoint during implementation.

## Migration Plan

1. Create migration to add `user_id` to `recu` table
2. Create `StatutRecu` and `CategorieDepense` enums
3. Update `Recu` and `Depence` models with new enum casts
4. Add `recus()` relationship to `User`
5. Create `StoreRecuRequest` and `StoreDepenseRequest`
6. Implement `RecuController` methods
7. Implement `DepenceController` methods
8. Create Blade views
9. Register routes
10. Run `sail artisan migrate`

Rollback: `sail artisan migrate:rollback` on the new migration, revert file changes via git.
