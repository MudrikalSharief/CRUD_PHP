<?php
    require_once("book.class.php");

    $books = new Book();
    $array = $books->get_all_coloumn();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="heading">
        <h1>BOOK</h1>
        <a href="addbook.php"><button>Add book</button></a>
    </div>
    <h2>Books Table</h2>

    <table >
            <tr class="title_row">
                <th>No.</th>
                <th>Barcode</th>
                <th >Title</th>
                <th >Author</th>
                <th>Genre</th>
                <th>Publisher</th>
                <th>Date Published</th>
                <th>Edition</th>
                <th>Copies</th>
                <th>Format</th>
                <th >Age Group</th>
                <th>Rating</th> 
                <th >Description</th>
                <th>Action</th>
            </tr>
            
            <?php
                $counter = 1;
                $bg="";
                foreach($array as $arr){
                if($counter%2==1){
                    $bg="bg";
                }
                else{
                    $bg="";
                }
             ?>       

                <tr class="<?= $bg ?>">
                    <td ><?= $counter ?></td>
                    <td><?= $arr['barcode']?></td>
                    <td ><?= $arr['book_title'] ?></td>
                    <td><?= $arr['book_author'] ?></td>
                    <td><?= $arr['book_genre'] ?></td>
                    <td><?= $arr['book_publisher'] ?></td>
                    <td><?= $arr['publication_date'] ?></td>
                    <td><?= $arr['book_edition'] ?></td>
                    <td><?= $arr['book_copies'] ?></td>
                    <td><?= $arr['book_format'] ?></td>
                    <td><?= $arr['age_group'] ?></td>
                    <td ><?= $arr['book_rating'] ?>/5</td>
                    <td ><?= $arr['book_description'] ?></td>
                    
                    <td><a href="edit.php?id=<?= $arr['book_id']?>" class="edit">edit</a></td>
                    
                </tr>

            <?php
                $counter++;
                }
            ?>
    </table>
    
  
</body>
</html>