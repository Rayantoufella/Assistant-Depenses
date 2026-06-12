
## 1. Database & Models

- [ ] 1.1 Create migration `add_user_id_to_recu_table` adding `user_id` FK to `recu` table
- [ ] 1.2 Create `StatutRecu` enum (`App\Enums\StatutRecu`) with cases `en_attente`, `traite`, `echoue`
- [ ] 1.3 Create `CategorieDepense` enum (`App\Enums\CategorieDepense`) with cases `alimentaire`, `boissons`, `hygiene`, `entretien`, `autre`
- [ ] 1.4 Update `Recu` model: use `StatutRecu` cast for `status`, rename `payload_ia` cast to `payload_brut`
- [ ] 1.5 Update `Depence` model: use `CategorieDepense` cast for `categorie`
- [ ] 1.6 Add `recus()` hasMany relationship to `User` model

## 2. Form Requests

- [ ] 2.1 Create `StoreRecuRequest` validating `text_source` (required, string, max:10000)

## 3. Controllers

- [ ] 3.1 Fix `RecuController`: correct column names (`text_source`, `status`), enum references (`StatutRecu`), relationship name (`depences`), user scoping via `auth()->user()->recus()`
- [ ] 3.2 Implement `DepenceController` with full resource methods (index, create, store, show, edit, update, destroy) scoped to receipt ownership

## 4. Views

- [ ] 4.1 Create `resources/views/recus/index.blade.php` — table listing user's receipts
- [ ] 4.2 Create `resources/views/recus/create.blade.php` — form to submit receipt text
- [ ] 4.3 Create `resources/views/recus/show.blade.php` — receipt detail with expenses table
- [ ] 4.4 Create `resources/views/depences/create.blade.php` — form to add expense to a receipt
- [ ] 4.5 Create `resources/views/depences/edit.blade.php` — form to edit an expense

## 5. Routes & Navigation

- [ ] 5.1 Register resource routes for `recus` and nested resource routes for `depences` under `auth` middleware
- [ ] 5.2 Add navigation link to receipts index in `layouts/navigation.blade.php`

## 6. Cleanup

- [ ] 6.1 Remove old `Status` and `Categorie` enum files if no longer referenced
- [ ] 6.2 Run `sail artisan migrate` and verify end-to-end CRUD flow
