package db.migration;

import org.flywaydb.core.api.migration.BaseJavaMigration;
import org.flywaydb.core.api.migration.Context;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;

/**
 * Flyway Java migration V4 - Rename admin password column for legacy databases.
 *
 * Problem: The original database (pre-Spring Boot migration) used `password` as the
 * column name in the `admin` table. The Spring Boot entity Admin.java uses
 * {@code @Column(name = "pass")}, so Hibernate schema validation fails with:
 * "Schema-validation: missing column [pass] in table [admin]"
 *
 * The V2 SQL migration uses CREATE TABLE IF NOT EXISTS, so it does not recreate
 * tables that already exist, leaving the legacy `password` column in place.
 *
 * This migration detects the legacy layout and renames `password` to `pass`.
 * It is a no-op on fresh databases (created by V2) that already have the `pass` column.
 */
public class V4__Rename_admin_password_column extends BaseJavaMigration {

    @Override
    public void migrate(Context context) throws Exception {
        Connection connection = context.getConnection();
        try (Statement stmt = connection.createStatement()) {
            boolean hasPasswordColumn = false;
            boolean hasPassColumn = false;

            try (ResultSet rs = stmt.executeQuery(
                    "SELECT COLUMN_NAME FROM information_schema.COLUMNS " +
                    "WHERE TABLE_SCHEMA = DATABASE() " +
                    "  AND TABLE_NAME = 'admin' " +
                    "  AND COLUMN_NAME IN ('password', 'pass')")) {
                while (rs.next()) {
                    String col = rs.getString("COLUMN_NAME");
                    if ("password".equals(col)) hasPasswordColumn = true;
                    if ("pass".equals(col))     hasPassColumn = true;
                }
            }

            // Only rename when the legacy 'password' column exists and 'pass' does not
            if (hasPasswordColumn && !hasPassColumn) {
                stmt.execute(
                    "ALTER TABLE `admin` CHANGE `password` `pass` VARCHAR(255) NOT NULL");
            }
        }
    }
}
