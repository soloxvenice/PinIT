<?php
//heyyyyyyyyyyyyyyy
session_start(); 

//Check if this client is authenticated (logged in)
if(isset($_SESSION['loggedin']))
{//The $_SESSION array is only assigned values after successful 
//authentication, so $_SESSION['loggedin'] will only be set if the user 
//if the user is already logged in
//Assign the data stored in the $_SESSION array to local variables
	$loggedin = $_SESSION['loggedin'];
	$accountid = $_SESSION['accountid'];
	$userDisplay = $_SESSION['userDisplay'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	//Set the menu options for authenticated users
	$menu = "<a href='pinit.php?action=account'>My Account</a> | <a href='pinit.php?action=logout'>Logout</a>";
}
else
{//User is not authenticated (not logged in)
	$loggedin = FALSE;
	//Set the menu options for non-authenticated users
	$menu = "<a href='pinit.php?action=loginform'>Login</a> | <a href='pinit.php?action=register'>Register</a>";
}
require("model/functions.php");
 
$action = filter_input(INPUT_POST, 'action');
if($action == NULL)
	$action = filter_input(INPUT_GET, 'action');
if($action == "Submit Comment")
{
    // Capture the data from the form
    $fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');
    $email = filter_input(INPUT_POST, 'email');
    $comment= filter_input(INPUT_POST, 'comment');
	addComment($fname, $lname, $email, $comment);
   
	include("view/comment_submitted.php");
}
elseif($action == 'edit')
{
	//User is trying to edit and update a specific comment.
	//This request is sent via the 'GET' method when the user clicks the 'edit' link
	//first capture the 'id' value of the record to be updated
	$id = filter_input(INPUT_GET, 'id');
	
	//Next call the 'getComment' function to get the data for that record
	$commentRecord = getComment($id);
	//Assign the values from the database results to individual variables
	$fname = $commentRecord['fname'];
	$lname = $commentRecord['lname'];
	$email = $commentRecord['email'];
	$comment = $commentRecord['comment'];
	//Finally show the 'edit' form populated with the data from the record
	//Note that we use a 'hidden' input element to include the record id in the form
	include("view/edit_form.php");
}
elseif($action == 'Update Comment')
{
	// Capture the data from the form
    $fname = filter_input(INPUT_POST, 'fname');
	$lname = filter_input(INPUT_POST, 'lname');
    $email = filter_input(INPUT_POST, 'email');
    $comment= filter_input(INPUT_POST, 'comment');
	$id = filter_input(INPUT_POST, 'id');
	//call the updateComment function and send the captured data as parameters
	updateComment($id, $name, $email, $comment);
	//Redirect the user back to the default view
	header("Location:pinit.php");
}
elseif($action == 'delete')
{
	//User is trying to delete a secific comment.
	//This request is sent via the 'GET' method when the user clicks the 'delete' link
	//first capture the 'id' value of the record to be deleted
	$id = filter_input(INPUT_GET, 'id');
	//Next call the 'deleteComment' function to delete that record
	deleteComment($id);
	//Redirect the user back to the default view
	header("Location:pinit.php");
}
elseif($action == 'like')
{
	// Capture the 'id' of the comment to be liked
	$id = filter_input(INPUT_GET, 'id');
	// Call the likeComment function to increment the likes
	likeComment($id);
	// Redirect the user back to the default view
	header("Location:pinit.php");
}
elseif($action == 'undo_like')
{
	// Capture the 'id' of the comment to undo the like
	$id = filter_input(INPUT_GET, 'id');
	// Call the undoLikeComment function to decrement the likes
	undoLikeComment($id);
	// Redirect the user back to the default view
	header("Location:pinit.php");
}
else
{
	//default view: Shows the new comment form and the list of comments
	//
	$comments = getComments();
	
	if($comments != NULL){
		$commentList = "<h2>Comments Found:</h2>";
		foreach($comments as $row){
			$fname = $row['fname'];
			$lname = $row['lname'];
			$email = $row['email'];
			$comment = $row['comment'];
			$id = $row['id'];
			$likes = isset($row['likes']) ? $row['likes'] : 0; // Default to 0 if 'likes' column is not set
			$commentList .= "<p>Name: $fname $lname email: $email <a href='pinit.php?action=edit&id=$id'>edit</a> | <a href='pinit.php?action=delete&id=$id'>delete</a> | <a href='pinit.php?action=like&id=$id'>like</a> | <a href='pinit.php?action=undo_like&id=$id'>undo like</a> ($likes likes)</p><p>$comment</p><hr>";
		}
	}
	else
		$commentList = "<h2> No comments found</h2>";
	include("view/header.php");
	include("view/default_view.php");
	echo "Hello everyone this is a test for git";
}
?>
