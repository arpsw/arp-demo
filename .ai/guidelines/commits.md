# Commit Conventions

This project follows **Conventional Commits**. Format: 
`<type>(<scope>): <title>

<description>

Tags: <tags>
`

## Commit Types

- **feat**: Add, adjust, or remove a feature
- **fix**: Fix a bug from a previous feat commit
- **refactor**: Rewrite/restructure code without behavior change
- **perf**: Performance improvements
- **style**: Code style changes (formatting, whitespace)
- **test**: Add or correct tests
- **docs**: Documentation changes only
- **build**: Build tools, dependencies, packages
- **ops**: Infrastructure, deployment, CI/CD
- **chore**: Miscellaneous tasks

## Rules

- Use imperative, present tense: "add" not "added"
- Do not capitalize first letter
- No period at end
- **Scopes are mandatory**: `feat(api):`, `fix(auth):`, `docs(readme):`
- Simple, breif title (max 50 chars) with more detailed description in body if needed
- For larger commits, use body to explain the "why" and "how" of the change, not just the "what"
- Add Tags line for important metadata (e.g., `Tags: breaking`, `Tags: needs-tests`, `Tags: docs-only`)

## AI Attribution

**CRITICAL**: Do not include AI-generated attribution in commit messages.

- No "🤖 Generated with Claude Code" lines
- No "Co-Authored-By: Claude" tags
- No emojis

## Examples

```bash
feat(resource): add filament UserResource with basic CRUD operations

Adds a new Filament Resource for managing users in the admin panel, including:
- User listing with pagination and search
- User creation and editing forms with validation
- Deletion with confirmation

Tags: filament, users, resources
```

```bash
fix(auth): resolve password reset token expiration bug

When users request a password reset, the generated token was expiring immediately due to incorrect timestamp handling. This commit fixes the issue by ensuring the token expiration time is set correctly in the database and validated properly during reset.

Tags: auth, password-reset, bugfix
```

```bash
refactor(api): extract user registration logic to RegisterUserService

The user registration logic was previously embedded in the AuthController, making it bulky and harder to test. This commit refactors the code by extracting the registration logic into a dedicated RegisterUserService class, which is then injected into the controller. This improves separation of concerns and makes the code more maintainable.

Tags: api, auth, refactor
```
