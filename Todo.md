## Basic Info Page

### Reis/Opleiding/AfstudeerRiching

#### Database Implementation:
- Create migrations for the following tables:
  - `trips` (id, name, description, start_date, end_date, max_participants, price, created_at, updated_at)
  - `educations` (id, name, description, created_at, updated_at)
  - `specializations` (id, name, education_id, description, created_at, updated_at)
- Create models with proper relationships:
  - `Trip` model with hasMany relationship to `Traveller`
  - `Education` model with hasMany relationship to `Specialization`
  - `Specialization` model with belongsTo relationship to `Education`

#### Cascading Dropdowns Implementation:
- Create AJAX endpoints in `EducationController`:
  - GET `/api/educations` - Returns all educations
  - GET `/api/educations/{id}/specializations` - Returns specializations for given education
- Implement JavaScript for dynamic dropdowns:
  - On education selection, trigger AJAX request to load relevant specializations
  - Clear specialization dropdown when education changes
  - Display loading indicator during AJAX requests

#### Form Validation:
- Server-side validation in controller for required fields
- Client-side validation using JavaScript/jQuery
- Display appropriate error messages

### Requirements

#### Trip Model Implementation:
- Create `Trip` model with relationships to:
  - `Education` (many-to-many)
  - `Specialization` (many-to-many)
  - `Traveller` (one-to-many)
- Add validation rules in model:
  - Name: required, max 255 chars
  - Dates: required, valid date format, end_date > start_date
  - Price: required, numeric, min 0
  - Max participants: required, integer, min 1

#### GuestRegistrationController Updates:
- Add method to handle trip, education, and specialization selection
- Store selections in session data
- Validate that selected combination is valid
- Redirect to Personal Info page upon validation

## Personal Info Page

## Stad

#### City Model Implementation:
- Create migration for `cities` table:
  - id
  - name (string, required)
  - postal_code (string, required)
  - province (string, required)
  - country (string, default 'Belgium')
  - coordinates (optional, for future map features)
  - created_at, updated_at
- Create `City` model with validation rules

#### Belgian Cities Seeder:
- Create `BelgianCitiesSeeder` class
- Research and obtain list of Belgian cities with postal codes
- Format data in array/JSON format for seeding
- Implement efficient batch insertion
- Add sorting by province and alphabetically
- Document data source in seeder comments

#### City Popup Form:
- Create modal/popup view `resources/views/components/city-form-modal.blade.php`
- Add form fields for name, postal code, province
- Implement AJAX submission to avoid page reload
- Display validation errors within modal
- Add success notification when new city is added
- Auto-update city dropdown when new city is added
- Focus back on form after submission

#### City Validation:
- Use Laravel's validation for:
  - Name: required, string, unique in cities table
  - Postal code: required, format validation for Belgian postal codes
  - Province: required, must be one of Belgian provinces
- Consider using package `monarobase/country-list` for country selection

#### GuestRegistrationController Updates:
- Create method to handle city selection
- Create method to handle new city submission via AJAX
- Update session data with selected city information
- Progress to next registration step

## Contact Info Page

#### Secondary Email Implementation:
- Add secondary email field:
  - Only show for users from "R" and "U" education types
  - Add conditional display logic based on education selection
  - Use JavaScript to toggle visibility
  - Validate format but mark as optional
- Ensure primary email is always required
- Update validation rules in controller

#### Button Text Change:
- Change "registreer" button to "Volgende"
- Update CSS styling to match design
- Keep same form submission logic
- Add forward arrow icon to button

#### Controller Logic:
- Validate contact information
- Store in session data
- Redirect to confirmation page

## Confirmation Page 

#### View Implementation:
- Create `resources/views/guest/confirmation.blade.php`
- Display all collected information from session organized by category:
  - Trip information
  - Personal details
  - Address information
  - Contact information
- Add "Edit" links next to each section to go back to specific form
- Include final "Bevestigen" button

#### GuestRegistrationController Updates:
- Create `showConfirmation` method to display confirmation page
- Create `processConfirmation` method to:
  - Create new `Traveller` record in database
  - Associate with selected trip
  - Clear session data
  - Redirect to success page

#### Redirect Logic:
- Upon successful registration, redirect to homepage
- Add flash message to session for success notification
- Include trip details in success message

## Traveller Creation

#### Account Creation:
- Generate random 10-character password with:
  - At least one uppercase letter
  - At least one lowercase letter
  - At least one number
  - At least one special character
- Hash password before storing in database
- Create traveller record with all collected information
- Link traveller to selected trip

#### Email Confirmation:
- Create email template `resources/views/emails/registration-confirmation.blade.php`
- Include:
  - Welcome message
  - Trip details (name, dates)
  - Account credentials (email and temporary password)
  - Login link
  - Password change instructions
  - Contact information for support
- Use Laravel's Mailable class for sending
- Queue emails for better performance
- Add fallback for failed emails

#### Testing Requirements:
- Unit test for password generation
- Feature test for registration flow
- Test email sending functionality
- Test database record creation

