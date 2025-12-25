# Flyway Database Migrations

This directory contains Flyway migration scripts for the iRoom database.

## Migration File Naming Convention

Flyway migrations must follow this naming pattern:

```
V{version}__{description}.sql
```

**Examples:**
- `V1__Initial_baseline.sql` - Baseline migration
- `V2__Add_user_email_column.sql` - Add email column to User table
- `V3__Create_audit_log_table.sql` - Create new audit log table

**Rules:**
- Version number must start with `V`
- Use double underscore `__` between version and description
- Description should use underscores for spaces
- Use `.sql` extension

## Current Migrations

### V1__Initial_baseline.sql
Baseline migration for the existing database. This migration documents the current schema but doesn't create any tables since they already exist. The project is configured with `baseline-on-migrate=true`.

## Creating New Migrations

When you need to change the database schema:

1. Create a new migration file with the next version number:
   ```bash
   cd backend/src/main/resources/db/migration
   touch V2__Your_description_here.sql
   ```

2. Add your SQL changes to the file:
   ```sql
   -- V2__Add_user_email_column.sql

   ALTER TABLE User
   ADD COLUMN email VARCHAR(255);

   CREATE INDEX idx_user_email ON User(email);
   ```

3. Test your migration:
   ```bash
   cd backend
   mvn clean install
   mvn spring-boot:run
   ```

4. Flyway will automatically:
   - Detect the new migration
   - Execute it on startup
   - Record it in the `flyway_schema_history` table

## Flyway Commands

### Check migration status
```bash
mvn flyway:info
```

### Validate migrations
```bash
mvn flyway:validate
```

### Repair migration history (if needed)
```bash
mvn flyway:repair
```

## Configuration

Flyway is configured in `application.properties`:

```properties
spring.flyway.enabled=true
spring.flyway.baseline-on-migrate=true
spring.flyway.baseline-version=0
spring.flyway.locations=classpath:db/migration
spring.flyway.encoding=UTF-8
spring.flyway.validate-on-migrate=true
```

## Important Notes

1. **Never modify existing migrations** - Once a migration is applied, it's recorded in the database. Create a new migration instead.

2. **Baseline on migrate** - This project uses `baseline-on-migrate=true` because the database already exists. This tells Flyway to mark V1 as completed without running it.

3. **Version control** - Always commit migration files to git.

4. **Rollback** - Flyway Community Edition doesn't support automatic rollback. If you need to undo a migration:
   - Create a new migration with the reverse changes
   - Example: If V2 added a column, create V3 to drop it

5. **Data migrations** - You can include data changes (INSERT, UPDATE, DELETE) in migration files, but be careful with production data.

## Troubleshooting

### Migration failed
If a migration fails:
1. Fix the SQL in the migration file
2. Run `mvn flyway:repair` to mark the failed migration as resolved
3. Run the application again

### Out of order migrations
If you need to apply a migration that's older than the last applied version:
```properties
spring.flyway.out-of-order=true
```

### Skip specific migrations
```properties
spring.flyway.ignore-missing-migrations=true
```

## Best Practices

1. **Keep migrations small** - One logical change per migration
2. **Test locally first** - Always test migrations before deploying
3. **Use transactions** - Wrap DDL in transactions when possible
4. **Document changes** - Add comments explaining why the change was made
5. **Backward compatible** - Try to make migrations non-breaking
6. **Index management** - Remember to add indexes for new columns used in queries

## Example Migration Workflow

```bash
# 1. Create new migration
touch V2__Add_user_phone_number.sql

# 2. Edit the file
cat > V2__Add_user_phone_number.sql << 'EOF'
-- Add phone number support for users
ALTER TABLE User
ADD COLUMN phone_number VARCHAR(20);

-- Add index for phone lookups
CREATE INDEX idx_user_phone ON User(phone_number);
EOF

# 3. Run application (Flyway runs automatically)
mvn spring-boot:run

# 4. Verify migration
mvn flyway:info

# 5. Commit to git
git add .
git commit -m "Add phone number column to User table"
```

## Schema History Table

Flyway creates and maintains a `flyway_schema_history` table in your database:

```sql
SELECT * FROM flyway_schema_history ORDER BY installed_rank;
```

This table tracks:
- Which migrations have been applied
- When they were applied
- Execution time
- Success/failure status
- Checksums for validation
