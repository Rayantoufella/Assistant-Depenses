
## ADDED Requirements

### Requirement: User can create a receipt
The system SHALL allow an authenticated user to create a new receipt by submitting the raw text source of a supplier receipt.

#### Scenario: Successful receipt creation
- **WHEN** an authenticated user submits valid `text_source` via the receipt creation form
- **THEN** the system creates a new `Recu` record with `status` = `en_attente`, `user_id` = the authenticated user's ID, and redirects to the receipt list with a success message

#### Scenario: Validation failure — missing text_source
- **WHEN** an authenticated user submits the form with an empty `text_source`
- **THEN** the system SHALL return validation errors and NOT create a receipt

#### Scenario: Unauthenticated user redirected
- **WHEN** an unauthenticated user attempts to access the create form or submit a receipt
- **THEN** the system SHALL redirect to the login page

### Requirement: User can list their receipts
The system SHALL display a paginated list of all receipts belonging to the authenticated user, ordered by most recent first.

#### Scenario: Viewing receipt list
- **WHEN** an authenticated user navigates to the receipts index page
- **THEN** the system SHALL display a list of their receipts showing `created_at`, `status`, the first 100 characters of `text_source`, and the number of associated expenses

#### Scenario: User sees only their own receipts
- **WHEN** an authenticated user views the receipt list
- **THEN** the system SHALL NOT display receipts belonging to other users

### Requirement: User can view a single receipt
The system SHALL show the full details of a single receipt, including its associated expenses.

#### Scenario: Viewing own receipt
- **WHEN** an authenticated user navigates to a receipt detail page for a receipt they own
- **THEN** the system SHALL display the full `text_source`, status, creation date, and a table of associated expenses (libelle, quantite, prix_unitaire, categorie)

#### Scenario: Viewing another user's receipt returns 404
- **WHEN** an authenticated user attempts to view a receipt that belongs to another user
- **THEN** the system SHALL return a 404 response

### Requirement: User can delete a receipt
The system SHALL allow an authenticated user to delete their own receipt and its associated expenses.

#### Scenario: Successful deletion
- **WHEN** an authenticated user deletes a receipt they own
- **THEN** the system SHALL delete the receipt and all its associated expenses, then redirect to the receipt list with a success message

#### Scenario: Deleting another user's receipt returns 404
- **WHEN** an authenticated user attempts to delete a receipt belonging to another user
- **THEN** the system SHALL return a 404 response
