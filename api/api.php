<?php 
include_once('../config/connection.php');
 // ini_set("display_errors", 1);
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
$post = array();
$respone = [
  'status' => 'failed',
  'message' => 'Something wnet wrong!'
];
if($REQUEST_METHOD == 'POST'){ 
  $name = $_POST['name'];
  $author = $_POST['author'];
  $sql = "INSERT INTO post (name, author) VALUES ('".$name."', '".$author."')";
  $query = $conn->query($sql);
  $post = [
      'name' => $name,
      'author' => $author
  ];

  if((!empty($name)) && (!empty($author))){
      if($query){
          $respone = [
            'status' => 'suceess',
            'message' => 'Post added suceessfully',
            'data' => $post
          ];
      }else{
          $respone = [
            'status' => 'failed',
            'message' => 'Something went wrong!'
          ];
      }
  }else{
    $respone = [
      'status' => 'failed',
      'message' => 'Please provide Name and Author for Post'
    ];
  }
}else if($REQUEST_METHOD == 'PUT'){
    parse_str(file_get_contents('php://input'), $_PUT);
    $id = $_PUT['id'];
    $name = $_PUT['name'];
    $author = $_PUT['author'];
    $post = [
      'id' => $id,
      'name' => $name,
      'author' => $author
    ];
    
    $sql = "UPDATE post SET name = '".$name."' , author = '".$author."' WHERE id='".$id."' ";
    $query = $conn->query($sql);
    if ((!empty($name) || !empty($author)) && !empty($id)) {
      if($query){
        $respone = [
          'status' => 'suceess',
          'message' => 'Post Updated suceessfully',
          'data' => $post
        ];
      }else{
        $respone = [
          'status' => 'failed',
          'message' => 'Something went wrong!'
        ];
      }
    }else{
      $respone = [
        'status' => 'failed',
        'message' => 'Please provide Post ID and name or author for Post!'
      ];
    }
}else if($REQUEST_METHOD == 'DELETE'){
  $id = $_GET['id'];
  
  $post = [
    'id' => $id
  ];
  $sql = "DELETE FROM post WHERE id = ".$id." ";
  $query = $conn->query($sql);
  if(!empty($id)){
    if($query){
      $respone =[
          'status' => 'suceess',
          'message' => 'Post Deleted suceessfully',
          'data' => $post
      ];
    }else{
      $respone = [
        'status' => 'failed',
        'message' => 'Something went wrong!'
      ];
    }
  }else{
    $respone = [
      'status' => 'failed',
      'message' => 'Please provide ID for Post'
    ];
  }
}else{
  $sql = "SELECT * FROM post";
  $query = $conn->query($sql);
  if($query->num_rows > 0){
    $counter = 1;
    while($row = $query->fetch_assoc()) {
      $post[$counter]['id'] = $row['id'];
      $post[$counter]['name'] = $row['name'];
      $post[$counter]['author'] = $row['author'];
      $post[$counter]['created_at'] = $row['created_at'];
      $counter ++;
    }
    $respone = [
      'status' => 'sucess',
      'message' => 'Post fetched suceessfully',
      'data' => $post
    ];
  }else{
    $respone = [
      'status' => 'failed',
      'message' => 'No Post found'
    ];
  }

}
echo json_encode($respone);
?>