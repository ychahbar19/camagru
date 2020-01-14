    <section class="col-lg-12 col-md-12 centered">
        <div class="checkbox">
            <form action="" method="post">
                <div class="disable-notif--checkbox-div">
                        <input type="checkbox" name="notif-checkbox" value="yes" <?php if ($_SESSION['notification_bool'] == 1) {echo "checked";} ?>>
                        <label>disable mail notifications.</label>
                </div>
                <div class="disable-notif--button-div">
                    <button type="submit" class="btn btn-primary" name="notification-button">save</button>
                </div>
            </form>
        </div>
    </section>
</div>
