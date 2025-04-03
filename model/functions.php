<?php
//Connection information for finding and connecting to the MySQL server
//Since this is a development environment in XAMPP, we are using 'root' user with no password

 $dsn = 'mysql:host=localhost;dbname=pinit';
 $dbuser = 'root';
 $dbpass = '';
 //use the variables above to create a new PDO object: $db
 //This variable now contains the information needed to interact
 //with the MySQL database
 $db = new PDO($dsn, $dbuser, $dbpass);
function addComment($fname, $lname, $email, $comment) 
{
 
	//This function inserts a new record in the table
	  
	global $db; //Make $db accessible inside the function block 
	  
	//The SQL - this is to add a new record in the table 
	//Note the 'placeholders' :col_one, :col_two, :col_three

	$query = 'INSERT INTO comments(fname, lname, email, comment) VALUES (:fname, :lname, :email, :comment)'; 

	//Call the prepare method from the $db object  
	//to setup a prepared (secure) interaction with the database 

	$statement = $db->prepare($query);  

	//'bind' each variable to the placeholders specified in the SQL query 
	$statement->bindValue(':fname', $fname);  
	$statement->bindValue(':lname', $lname);  
	$statement->bindValue(':email', $email); 
	$statement->bindValue(':comment', $comment); 
	
	

	//Execute the SQL command 

	$statement->execute();  

	//Our interaction with the DB is done, close the connection to the server  

	$statement->closeCursor();  

	//There is nothing to return from this function

}
function getComments()
{
	//This function finds all records in the specified table
	//and returns them as a result set (2-dimensional associative array)

	global $db; 
	 
	//Setup the SQL statement - no placeholders needed
	$query = 'SELECT * FROM comments';
	$statement = $db->prepare($query);
	$statement->execute();

	//We use the fetchAll() function because we expect
	//that there could be multiple results
	//After this statement, $records contains all the data for the found records
	// stored as a 2-dimensional associative array

	$comments = $statement->fetchAll();
	$statement->closeCursor();

	//return the $records found
	return $comments;
}
function getComment($id)
{
	//This function finds a single record based on the id (primary key) 

	global $db; //Make the $db visible within the function
	  
	//Since we are using a variable $id as part of the SQL statement 
	//we need to use a placeholder  ':id' 

	$query = 'SELECT * FROM comments WHERE id = :id';  
	$statement = $db->prepare($query);  

	//'bind' the variable to the placeholder 
	$statement->bindValue(':id', $id); 
	$statement->execute();  

	//This query will find at most 1 matching record,  
	//so we use the fetch() function here instead of fetchAll()
	 
	$comment = $statement->fetch(); 
	$statement->closeCursor();   
	//return the record- $comment is a 1-dimensional associative array 
	return $comment;
	
}
function updateComment($id, $name, $email, $comment)
{
	global $db; //Make $db accessible inside the function block  

	//The SQL - this is to update an existing entry in the table 
	//Note the 'placeholders' :col_one, :col_two, :col_three, :id 

	$query = 'UPDATE comments SET name= :name, email= :email, comment= :comment WHERE id = :id';    

	//Call the prepare method from the $db object  
	//to setup a prepared (secure) interaction with the database 

	$statement = $db->prepare($query);  

	//'bind' each variable to the placeholders specified in the SQL query 
	$statement->bindValue(':name', $name); 
	$statement->bindValue(':email', $email); 
	$statement->bindValue(':comment', $comment);  
	$statement->bindValue(':id', $id); 

	//Execute the SQL command 

	$statement->execute();  

	//Our interaction with the DB is done, close the connection to the server  

	$statement->closeCursor();  

	//There is nothing to return from this function 
	
}
function deleteComment($id)
{
	//This function deletes an single record from the table based on the id 

	global $db; 

	//setup the query - id comes from the client, so use a placeholder, :id 

	$query = 'DELETE FROM comments WHERE id = :id'; 

	$statement = $db->prepare($query);  

	$statement->bindValue(':id', $id); 

	$statement->execute();  

	$statement->closeCursor();   

	//There is nothing to return from this function
		
}
function likeComment($id) {
    global $db; // Make $db accessible inside the function block

    // The SQL - increment the 'likes' column for the specified comment
    $query = 'UPDATE comments SET likes = likes + 1 WHERE id = :id';

    // Prepare the SQL statement
    $statement = $db->prepare($query);

    // Bind the variable to the placeholder
    $statement->bindValue(':id', $id);

    // Execute the SQL command
    $statement->execute();

    // Close the connection to the server
    $statement->closeCursor();
}
function undoLikeComment($id) {
    global $db; // Make $db accessible inside the function block

    // The SQL - decrement the 'likes' column for the specified comment, ensuring it doesn't go below 0
    $query = 'UPDATE comments SET likes = GREATEST(likes - 1, 0) WHERE id = :id';

    // Prepare the SQL statement
    $statement = $db->prepare($query);

    // Bind the variable to the placeholder
    $statement->bindValue(':id', $id);

    // Execute the SQL command
    $statement->execute();

    // Close the connection to the server
    $statement->closeCursor();
}
function notEmptyAccount($username, $password, $email, $fname, $lname)
	{
		//Not every function deals with DB connections
		//This function checks for empty variables and is used for form validation
		//returns true if non of the variables (parameters) are empty or returns false if one or more of them are empty
		if(empty($username) OR empty($password) OR empty($email) OR empty($fname) OR empty($lname))
			return false;
		
		return true;
	}
	
	function addAccount($username, $password, $email, $fname, $lname)
	{
		//Inserts a new account in the accounts table
		global $db; //Make $db accessible inside the function block
		
		$query = 'INSERT INTO accounts (username, password, email, fname, lname)
				  VALUES (:username, :password, :email, :fname, :lname )';
		$statement = $db->prepare($query);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':fname', $fname);
		$statement->bindValue(':lname', $lname);
		$statement->execute();
		$statement->closeCursor();	
	}
	function getAccount($id)
	{
		//Finds and returns a single account based on the 'id' column 
		global $db;
		$query = 'SELECT * FROM accounts WHERE id = :id';
		$statement = $db->prepare($query);
		$statement->bindValue(':id', $id);
		$statement->execute();
		$account = $statement->fetch();
		$statement->closeCursor();	
		//return the account - $account is a 1-dimensional associative array
		return $account;
	}
	function checkUsername($username)
	{
		//Checks if a username submitted for registration is available
		//Usernames must be unique
		//Function returns true if the username is available and false if it is not
		global $db;
		$queryUser = 'SELECT id FROM accounts
					  WHERE username = :username' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':username', $username);
		
		$statement1->execute();
		$userAccount = $statement1->fetch();
		$statement1->closeCursor();
		if($userAccount == NULL)
			return true;
		else
			return false;
		
	}
	function processLogin($username, $password)
	{
		//This function receives the username and password entered by the user in the Login form
		//It queries the accounts table using the username to see if a match was found
		//Since the username field is set as unique in the DB, only a single record will match
		//Or no records will match if the username does not exist in the table
		//If a record is found, then the supplied password will be compared to the password stored in the database and returned with the query results
		//The function will return the matching account if the login is correct
		//It will return NULL if the login was incorrect
		global $db;
		$queryUser = 'SELECT * FROM accounts
					  WHERE username = :username' ;
		$statement1 = $db->prepare($queryUser);
		$statement1->bindValue(':username', $username);
			
		$statement1->execute();
		$userAccount = $statement1->fetch();
		$statement1->closeCursor();
		//At this point, $userAccount either contains the matching record 
		//or is NULL if no match was found
		if($userAccount != NULL)
		{
			//username was found in the DB, now verify the password
			if($password == $userAccount['password'])
				return $userAccount; //Login successful
			else
				return NULL; //incorrect pass	
		}
		else
			return NULL; //incorrect username
	}
?>