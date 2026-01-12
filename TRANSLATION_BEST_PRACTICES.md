# Translation Best Practices

## Philosophy

This project follows a clear translation strategy:

- **Technical issues** → English (exceptions, system errors, logs)
- **Domain/Business logic** → Translatable (entities, forms, UI elements)

## Structure

### 1. EasyAdminBundle Translations (`translations/EasyAdminBundle.{locale}.yaml`)

These files contain translations for **EasyAdmin's built-in UI elements**:
- Page titles (dashboard, index, edit, new, detail)
- Actions (create, save, delete, cancel)
- Filters and pagination
- Form elements
- User interface components

**Example:**
```yaml
action:
  new: 'Add %entity_label_singular%'
  edit: 'Edit'
  delete: 'Delete'

paginator:
  first: 'First'
  previous: 'Previous'
  next: 'Next'
```

### 2. Messages Translations (`translations/messages.{locale}.yaml`)

These files contain translations for **domain-specific/business logic**:
- Entity names (students, classes, professors, etc.)
- Form labels (name, birth_date, address, etc.)
- Dashboard statistics and metrics
- Menu items
- Custom application messages

**Example:**
```yaml
entity:
  student: 'Student'
  students: 'Students'
  class: 'Class'

form:
  name: 'Last Name'
  first_name: 'First Name'
  birth_date: 'Birth Date'
```

## Implementation in Controllers

### Dashboard Controller

```php
public function configureDashboard(): Dashboard
{
    return Dashboard::new()
        ->setTitle('app.name')  // Uses translation key
        ->setTranslationDomain('messages');  // Specifies translation domain
}

public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('menu.dashboard', 'fa fa-chart-line');
    yield MenuItem::section('menu.students_classes');
    yield MenuItem::linkToCrud('entity.students', 'fa fa-user-graduate', Etudiant::class);
}
```

### CRUD Controllers

```php
public function configureCrud(Crud $crud): Crud
{
    return $crud
        ->setEntityLabelInSingular('entity.student')  // Translation key
        ->setEntityLabelInPlural('entity.students');  // Translation key
}

public function configureFields(string $pageName): iterable
{
    yield TextField::new('nom', 'form.name');  // Translation key
    yield TextField::new('prenom', 'form.first_name');  // Translation key

    yield ChoiceField::new('genre', 'form.gender')
        ->setChoices([
            'form.male' => 'M',    // Translation key
            'form.female' => 'F',  // Translation key
        ]);
}
```

## Important YAML Syntax Rules

### Reserved Keywords Must Be Quoted

In YAML, certain keywords like `true`, `false`, `null` are reserved and **must be quoted** when used as keys:

```yaml
# ❌ WRONG - Will cause syntax error
label:
  true: 'Yes'
  false: 'No'
  null: 'Null'

# ✅ CORRECT - Keywords are quoted
label:
  'true': 'Yes'
  'false': 'No'
  'null': 'Null'
```

## What Should NOT Be Translated

Keep these elements in **English** (technical/system level):
- Exception messages (internal errors)
- Log messages
- Debug information
- System configuration
- Database field names (in code)
- CSS classes and IDs
- API endpoint names

**Example of what stays in English:**
```php
// Exception messages - stay in English
throw new \Exception('Invalid student ID provided');

// Logging - stay in English
$logger->error('Failed to save student record');

// Technical validation - stay in English
if (!$entity instanceof Etudiant) {
    throw new \InvalidArgumentException('Expected Etudiant entity');
}
```

## Available Locales

The application supports three locales:
- `fr` - Français (French)
- `en` - English
- `ar` - العربية (Arabic)

## Adding New Translations

When adding new features:

1. **Add translation keys** to all three locale files:
   - `translations/messages.fr.yaml`
   - `translations/messages.en.yaml`
   - `translations/messages.ar.yaml`

2. **Use translation keys** in controllers instead of hard-coded text:
   ```php
   // ❌ BAD - Hard-coded text
   yield TextField::new('email', 'Adresse email');

   // ✅ GOOD - Translation key
   yield TextField::new('email', 'form.email');
   ```

3. **Clear cache** after adding translations:
   ```bash
   php bin/console cache:clear
   ```

## Testing Translations

1. Access the admin panel: `/admin`
2. Use the language switcher in the top-right corner
3. Switch between French, English, and Arabic
4. Verify all UI elements are translated correctly

## Common Translation Keys

### Entity Names
- `entity.student` / `entity.students`
- `entity.class` / `entity.classes`
- `entity.professor` / `entity.professors`
- `entity.absence` / `entity.absences`
- `entity.evaluation` / `entity.evaluations`
- `entity.grade` / `entity.grades`
- `entity.session` / `entity.sessions`
- `entity.exercise` / `entity.exercises`

### Form Fields
- `form.id` - ID
- `form.name` - Last Name
- `form.first_name` - First Name
- `form.birth_date` - Birth Date
- `form.gender` - Gender
- `form.male` / `form.female`
- `form.address` - Address
- `form.phone` - Phone Number
- `form.status` - Active Status
- `form.class` - Class
- `form.description` - Description
- `form.year` - School Year

### Menu Items
- `menu.dashboard`
- `menu.students_classes`
- `menu.teachers`
- `menu.evaluations`
- `menu.logout`

### Actions (from EasyAdmin)
- `action.new`
- `action.edit`
- `action.delete`
- `action.detail`
- `action.save`
- `action.cancel`

## Summary

✅ **DO translate:**
- Entity names and labels
- Form field labels
- Menu items
- Dashboard statistics
- User-facing messages
- Business domain terms

❌ **DON'T translate:**
- Exception messages
- Log entries
- Debug information
- System configuration
- Technical error messages

This approach ensures that:
- Developers can debug in English (universal technical language)
- End users see content in their preferred language
- Code remains maintainable and professional
