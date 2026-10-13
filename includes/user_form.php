<?php if ($errors): ?><div class="alert alert-danger">
        <ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
    </div><?php endif; ?>
<form method="post" autocomplete="off"><?= csrf_field() ?><div class="row g-3">
        <div class="col-md-6"><label class="form-label">Username *</label><input class="form-control" name="username" maxlength="100" value="<?= htmlspecialchars($data['username']) ?>" required autocomplete="off">
            <div class="form-text">Letters, numbers, dot, dash and underscore only.</div>
        </div>
        <div class="col-md-6"><label class="form-label">Email *</label><input class="form-control" type="email" name="email" maxlength="150" value="<?= htmlspecialchars($data['email']) ?>" required></div>
        <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" maxlength="255" value="<?= htmlspecialchars($data['phone']) ?>"></div>
        <div class="col-md-6"><label class="form-label">Password <?= $passwordRequired ? '*' : '(leave blank to keep current)' ?></label><input class="form-control" type="password" name="password" <?= $passwordRequired ? 'required' : '' ?> autocomplete="new-password"></div>
        <div class="col-md-6"><label class="form-label">Confirm Password <?= $passwordRequired ? '*' : '' ?></label><input class="form-control" type="password" name="password_confirmation" <?= $passwordRequired ? 'required' : '' ?> autocomplete="new-password"></div>
        <div class="col-md-6"><label class="form-label">Status *</label><select class="form-select" name="status" required>
                <option value="1" <?= $data['status'] === '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $data['status'] === '0' ? 'selected' : '' ?>>Inactive</option>
            </select></div>
        <div class="col-12"><button class="btn btn-primary" type="submit"><?= htmlspecialchars($submitLabel) ?></button></div>
    </div>
</form>