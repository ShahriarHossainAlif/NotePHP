<?php
//INSERT INTO `notes` (`Serial No.`, `title`, `description`, `tstamp`) VALUES (NULL, 'Everything for you', 'Hey Bristy,\r\nYou know how much i love you & everything i do is for your and my parent\'s happiness.', current_timestamp());
$insert= false;
$server_name = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($server_name, $username, $password, $database);
if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST["title"];
  $description = $_POST["description"];

  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title' , '$description')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    //echo "The record has been inserted succesfully!";
    $insert= true;
  } else {
    echo "not successful for this error==> " . mysqli_error($conn);
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Php Crud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
  
</head>

<body>
    <!-- Edit Modal -->
    

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

          <form action="crud.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>

    </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Php Crud</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
    if($insert) {
      echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> You're note have been saved successfully.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
  ?>
  <div class="container my-4">
    <h2> Add a note</h2>
    <form action="crud.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>

    </form>
  </div>


  <div class="container" my-4>

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Serial No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno=0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno= $sno+1;
          echo "<tr>
      <th scope='row'>" . $sno . "</th>
      <td>" . $row['title'] . "</td>
      <td>" . $row['description'] . "</td>
      <td><button class='edit btn btn-sm btn-primary'>Edit</button>  <a href='/del'>Delete</a></td></td>
    </tr>";
        }
        ?>
        
        
      </tbody>
    </table>
  </div>
  <hr>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.form(edits).forEach((element) => {
      element.addEventListener("click", (e)=> {
        console.log("edit", e);
        tr= e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[1].innerText;
        description= tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description);
        titleEdit.value=title;
        descriptionEdit.value= description;
        
        $('#editModal').modal('toggle');
      })
    })
  </script>
</body>

</html>