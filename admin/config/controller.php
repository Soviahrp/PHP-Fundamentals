<?php


// query select data
use LDAP\Result;

function query($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $row = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//create category
function store_category($data)
{
    global $db;

    $title = sanitize($data['title']);
    $slug = sanitize($data['slug']);

    // tidak aman
    // $query = "INSERT INTO categories (title, slug) VALUES (?, ?)";

    //aman
    $stmt = $db->prepare("INSERT INTO categories (title, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $slug);
    $stmt->execute();

    return $stmt->affected_rows;
}


//delete category
function delete_category($id)
{
    global $db;

    $query = "DELETE FROM categories WHERE id_category = $id";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//Edit category
function update_category($post)
{
    global $db;

    $id_category = $post['id_category'];
    $title = $post['title'];
    $slug = $post['slug'];

    $query = "UPDATE categories SET title = '$title', slug = '$slug' WHERE id_category ='$id_category'";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// store film
function store_film($data)
{
    global $db;


    $url = sanitize($data['url']);
    $title = sanitize($data['title']);
    $slug = sanitize($data['slug']);
    $description = sanitize($data['description']);
    $release_date = sanitize($data['release_date']);
    $studio = sanitize($data['studio']);
    $category_id = sanitize((int)$data['category_id']);



    $query = "INSERT INTO films (url, title, slug, description, release_date, studio, category_id) VALUES ('$url', '$title', '$slug', '$description', '$release_date', '$studio', '$category_id')";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function delete_film($id)
{
    global $db;

    $stmt = mysqli_prepare($db, "DELETE FROM films WHERE id_film = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}

// Edit film
function update_film($post) 
{
    global $db; 

    $id_film = sanitize($post['id_film']); 
    $url = sanitize($post['url']);
    $title = sanitize($post['title']);
    $slug = sanitize($post['slug']);
    $description = sanitize($post['description']);
    $release_date = sanitize($post['release_date']);
    $studio = sanitize($post['studio']);
    $is_private = (int)sanitize($post['is_private']);
    $category_id = (int)sanitize($post['category_id']);

    // Menggunakan prepared statement
    $stmt = $db->prepare("UPDATE films SET url = ?, title = ?, slug = ?, description = ?, release_date = ?, studio = ?, is_private = ?,category_id = ? WHERE id_film = ?");
    $stmt->bind_param("ssssssiii", $url, $title, $slug, $description, $release_date, $studio, $is_private, $category_id, $id_film);
    $stmt->execute();

    return $stmt->affected_rows;
}

// store user
function store_user($data) 
{
    global $db;

    $username   = sanitize($data['username']); 
    $email      = sanitize($data['email']); 
    $password   = sanitize(password_hash($data['password'], PASSWORD_BCRYPT)); 

    // query dengan prepare statement
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)"); 
    $stmt->bind_param("sss", $username, $email, $password); 
    $stmt->execute(); 

    return $stmt->affected_rows; 
}

function update_user($data){
    global $db;

    $id_user = (int)$data['id_user'];
    $username = sanitize($data['username']);
    $email = sanitize($data['email']);

    $password = isset($data['password']) && !empty($data['password']) ?password_hash($data['password'], PASSWORD_BCRYPT) : null;

    if($password){
        $stmt = $db->prepare("UPDATE users SET username =?, email = ?, password = ? WHERE id_user = ?");
        $stmt->bind_param("sssi", $username, $email, $password, $id_user);
    }else{
        $stmt = $db->prepare("UPDATE users SET username =?, email =? WHERE id_user =?");
        $stmt->bind_param("ssi", $username, $email, $id_user);
    }

    $stmt->execute();

    return $stmt->affected_rows;
}

function delete_user($id){
    global $db;

    $stmt = mysqli_prepare($db, "DELETE FROM users WHERE id_user = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
    
}