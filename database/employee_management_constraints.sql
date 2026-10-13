-- Apply once after importing university_management (3).sql.
-- Review and resolve any duplicate/orphan rows before running on existing production data.
ALTER TABLE users
  MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  ADD UNIQUE KEY users_username_unique (username),
  ADD UNIQUE KEY users_email_unique (email);

ALTER TABLE employee_departments
  ADD UNIQUE KEY employee_departments_name_unique (name);

ALTER TABLE employee_designations
  ADD UNIQUE KEY employee_designations_name_unique (name);

ALTER TABLE employees
  ADD UNIQUE KEY employees_employee_id_unique (employee_id),
  ADD UNIQUE KEY employees_email_unique (email),
  ADD UNIQUE KEY employees_nid_unique (nid),
  ADD KEY employees_department_id_index (department_id),
  ADD KEY employees_designation_id_index (designation_id),
  ADD CONSTRAINT employees_department_fk FOREIGN KEY (department_id) REFERENCES employee_departments(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT employees_designation_fk FOREIGN KEY (designation_id) REFERENCES employee_designations(id) ON UPDATE CASCADE ON DELETE RESTRICT;
