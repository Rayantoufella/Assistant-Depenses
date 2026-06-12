
## ADDED Requirements

### Requirement: User can view expenses for a receipt
The system SHALL display all expenses associated with a given receipt, scoped to the authenticated user.

#### Scenario: Viewing expenses on receipt detail page
- **WHEN** an authenticated user views a receipt they own
- **THEN** the system SHALL display each expense's libelle, quantite, prix_unitaire, and categorie in a table

#### Scenario: Attempting to view expenses for another user's receipt
- **WHEN** an authenticated user navigates to a receipt they do not own
- **THEN** the system SHALL return a 404 response

### Requirement: User can create an expense on a receipt
The system SHALL allow an authenticated user to add a new expense line item to their own receipt.

#### Scenario: Successful expense creation
- **WHEN** an authenticated user submits valid `libelle`, `quantite`, `prix_unitaire`, and `categorie` for a receipt they own
- **THEN** the system SHALL create a new `Depence` record linked to that receipt and redirect to the receipt detail page with a success message

#### Scenario: Validation failure — missing fields
- **WHEN** an authenticated user submits the form with invalid or missing fields
- **THEN** the system SHALL return validation errors and NOT create the expense

#### Scenario: Creating expense on another user's receipt returns 404
- **WHEN** an authenticated user attempts to add an expense to a receipt they do not own
- **THEN** the system SHALL return a 404 response

### Requirement: User can edit an expense
The system SHALL allow an authenticated user to update an expense line item on their own receipt.

#### Scenario: Successful expense update
- **WHEN** an authenticated user submits updated `libelle`, `quantite`, `prix_unitaire`, or `categorie` for an expense on their own receipt
- **THEN** the system SHALL update the expense record and redirect to the receipt detail page with a success message

#### Scenario: Editing expense on another user's receipt returns 404
- **WHEN** an authenticated user attempts to edit an expense linked to a receipt they do not own
- **THEN** the system SHALL return a 404 response

### Requirement: User can delete an expense
The system SHALL allow an authenticated user to delete an expense line item from their own receipt.

#### Scenario: Successful expense deletion
- **WHEN** an authenticated user deletes an expense on their own receipt
- **THEN** the system SHALL delete the expense record and redirect to the receipt detail page with a success message

#### Scenario: Deleting expense on another user's receipt returns 404
- **WHEN** an authenticated user attempts to delete an expense linked to a receipt they do not own
- **THEN** the system SHALL return a 404 response
