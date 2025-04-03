<!DOCTYPE html>
<html>
    <head>
        <title>PinIT - PHP</title>
        <link rel="stylesheet" href="view/main.css">
    </head>
    <body>
        <main>
            <h1>User Input Form</h1>
            <form action="pinit.php" method="post" class="user-form">
                <fieldset>
                    <legend>Enter Your Comments</legend>
                    <label for="fname">First Name:</label>
                    <input type="text" name="fname" id="fname" class="form-input"><br>

					<label for="lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" class="form-input"><br>

                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-input"><br>

                    <label for="comments">Comments</label><br>
                    <textarea name="comment" id="comment" class="form-textarea"></textarea><br>
                
                    <input type="submit" name="action" value="Submit Comment" class="form-button">
                </fieldset>
            </form>
            <div class="comment-section">
                <h2>Pins</h2>
                <?php echo $commentList; ?>
            </div>
        </main>
    </body>
</html>