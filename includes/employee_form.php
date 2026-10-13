<?php $gender = [1 => 'Male', 2 => 'Female', 3 => 'Other'];
$marital = [1 => 'Married', 2 => 'Unmarried'];
$religion = [1 => 'Islam', 2 => 'Hindu', 3 => 'Buddhist', 4 => 'Christian'];
$types = [1 => 'Teacher', 2 => 'Staff', 3 => 'Support Staff'];
$statuses = [1 => 'Active', 0 => 'Inactive', 2 => 'Resigned', 3 => 'Terminated']; ?>
<?php if ($errors): ?><div class="alert alert-danger">
        <ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
    </div><?php endif; ?>
<form method="post"><?= csrf_field() ?><div class="row g-3">
        <div class="col-md-4"><label class="form-label">Employee ID</label><input class="form-control" name="employee_id" maxlength="50" value="<?= htmlspecialchars($data['employee_id']) ?>"></div>
        <div class="col-md-4"><label class="form-label">Full Name *</label><input class="form-control" name="name" maxlength="100" value="<?= htmlspecialchars($data['name']) ?>" required></div>
        <div class="col-md-4"><label class="form-label">Email</label><input class="form-control" type="email" name="email" maxlength="150" value="<?= htmlspecialchars($data['email']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Father's Name *</label><input class="form-control" name="father_name" maxlength="100" value="<?= htmlspecialchars($data['father_name']) ?>" required></div>
        <div class="col-md-6"><label class="form-label">Mother's Name *</label><input class="form-control" name="mother_name" maxlength="100" value="<?= htmlspecialchars($data['mother_name']) ?>" required></div>
        <div class="col-md-6"><label class="form-label">Department *</label><select class="form-select" name="department_id" required>
                <option value="">Select Department</option><?php while ($o = mysqli_fetch_assoc($departments)): ?><option value="<?= $o['id'] ?>" <?= $data['department_id'] == $o['id'] ? 'selected' : '' ?>><?= htmlspecialchars($o['name']) ?><?= $o['status'] == 0 ? ' (Inactive)' : '' ?></option><?php endwhile; ?>
            </select></div>
        <div class="col-md-6"><label class="form-label">Designation *</label><select class="form-select" name="designation_id" required>
                <option value="">Select Designation</option><?php while ($o = mysqli_fetch_assoc($designations)): ?><option value="<?= $o['id'] ?>" <?= $data['designation_id'] == $o['id'] ? 'selected' : '' ?>><?= htmlspecialchars($o['name']) ?><?= $o['status'] == 0 ? ' (Inactive)' : '' ?></option><?php endwhile; ?>
            </select></div>
        <div class="col-md-3"><label class="form-label">Joining Date</label><input class="form-control" type="date" name="joining_date" value="<?= htmlspecialchars($data['joining_date']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="date_of_birth" value="<?= htmlspecialchars($data['date_of_birth']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Resign Date</label><input class="form-control" type="date" name="resign_date" value="<?= htmlspecialchars($data['resign_date']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Terminate Date</label><input class="form-control" type="date" name="terminate_date" value="<?= htmlspecialchars($data['terminate_date']) ?>"></div>
        <?php foreach ([['gender', 'Gender', $gender], ['marital_status', 'Marital Status', $marital], ['religion', 'Religion', $religion], ['employee_type', 'Employee Type', $types], ['status', 'Status', $statuses]] as [$field, $label, $options]): ?><div class="col-md-4"><label class="form-label"><?= $label ?> *</label><select class="form-select" name="<?= $field ?>"><?php foreach ($options as $value => $text): ?><option value="<?= $value ?>" <?= $data[$field] == $value ? 'selected' : '' ?>><?= $text ?></option><?php endforeach; ?></select></div><?php endforeach; ?>
        <div class="col-md-4"><label class="form-label">Phone</label><input class="form-control" name="phone" maxlength="255" value="<?= htmlspecialchars($data['phone']) ?>"></div>
        <div class="col-md-4"><label class="form-label">NID</label><input class="form-control" name="nid" maxlength="255" value="<?= htmlspecialchars($data['nid']) ?>"></div>
        <div class="col-md-4"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= $data['sort_order'] ?>"></div>
        <div class="col-12"><button class="btn btn-primary" type="submit"><?= htmlspecialchars($submitLabel) ?></button></div>
    </div>
</form>