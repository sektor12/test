<form action="/admin/?action=articles" method="post" class="form login">
    <h2>Please login to continue</h2>
    <div class="form-field">
        <label for="username">Username:<span class="required">*</span></label>
        <input type="text" name="username" required  class="form-text" />
    </div>
    
    <div class="form-field">
        <label for="password">Password: <span class="required">*</span></label>
        <input type="password" name="password" required  class="form-text" />
    </div>
    
    <div class="form-field">
        <input type="submit" name="login" value="Log In" class="form-submit"/>
    </div>
</form>