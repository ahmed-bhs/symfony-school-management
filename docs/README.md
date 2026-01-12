# Documentation

This is the documentation for the School Management System built with Symfony 7.4.

## View Online

The documentation is available at: https://ahmed-bhs.github.io/symfony-school-management/

## Local Development

### Prerequisites

- Ruby 2.7 or higher
- Bundler gem

### Setup

```bash
cd docs
bundle install
```

### Serve Locally

```bash
bundle exec jekyll serve
```

Open your browser to http://localhost:4000/symfony-school-management/

### Live Reload

```bash
bundle exec jekyll serve --livereload
```

## Documentation Structure

```
docs/
├── _config.yml              # Jekyll configuration
├── Gemfile                  # Ruby dependencies
├── index.md                 # Home page
├── getting-started/         # Installation and quick start
├── user-guide/              # User documentation
├── architecture/            # System architecture
├── database/                # Database schema
├── development/             # Development guide
└── migration/               # Migration from Symfony 3.1
```

## Contributing to Documentation

1. Fork the repository
2. Create a new branch
3. Edit markdown files in `docs/`
4. Test locally with `bundle exec jekyll serve`
5. Submit a pull request

## Documentation Style

- Use clear, concise language
- Include code examples
- Add screenshots when helpful
- Use callouts for important notes
- Keep navigation logical

### Callout Examples

```markdown
{: .note }
This is a note.

{: .warning }
This is a warning.

{: .important }
This is important information.
```

## Theme

This documentation uses the [Just the Docs](https://just-the-docs.github.io/just-the-docs/) theme.

## Support

For issues with the documentation:
- Open an issue on GitHub
- Submit a pull request with improvements
