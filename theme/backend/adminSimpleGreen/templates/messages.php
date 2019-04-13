<div class="messages-placeholder">
    <?php  
        if (!empty($messages)) {
            foreach ($messages as $message) {
                print "<div class='messages-rectangle " . $message['type'] . "'>";
                print "<div class='message " . $message['type'] . "'>" . $message['text'] . "</div>";
                print "</div>";
            }
        }
    ?>
</div>