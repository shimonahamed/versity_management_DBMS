-- Demo login: demo_admin / Admin@123
SET @demo_user_id = (SELECT COALESCE(MAX(id), 0) + 1 FROM users);

INSERT INTO users (id, username, email, password, status, created_at, updated_at)
SELECT @demo_user_id, 'demo_admin', 'demo.admin@example.com',
       '$2y$10$6pySiXfUg6Wjmudh07eckOU9sTq34hvOEUekE9i1tEHFyhRi0FZPe',
       1, NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM users
    WHERE username = 'demo_admin' OR email = 'demo.admin@example.com'
);

UPDATE users
SET password = '$2y$10$6pySiXfUg6Wjmudh07eckOU9sTq34hvOEUekE9i1tEHFyhRi0FZPe',
    status = 1,
    updated_at = NOW()
WHERE username = 'demo_admin' OR email = 'demo.admin@example.com';
