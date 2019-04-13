<form action="/admin/?action=articles" method="post" class="filter-by-user">
    <div class="form-field">
        <label for="filterby">Filter by user:</label>
        <select name="filterby">
            <option value="0">- All -</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php print $user['id']; ?>" <?php print $user['id'] == $filter ? 'selected' : ''; ?>><?php print $user['username']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-field">
        <input type="submit" name="filter" value="Filter" class="form-submit" />
    </div>
</form>