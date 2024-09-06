<?php
    require_once("book.class.php");

    $books = new Book();
    $array = $books->get_all_coloumn();
    $keyword = $category ="";
    $age_group=[];
    $string_group = "";
    
    if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['search']){
        $keyword =htmlentities( $_POST['searchbar']);
        $category = htmlentities($_POST['genre']);
        $format = htmlentities($_POST['format']);
        $age_group =  isset(($_POST['agegroup'])) ? $_POST['agegroup'] : [] ;
        $string_group = implode(',',$age_group);

        $array=$books->get_all_coloumn($keyword, $category, $format, $string_group);
        
    }

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

        <form action="" method="POST">

            
            <label for="genre">Genre</label>
            <select  id="genre" name="genre">
                <option value="">All</option>
                <option value="Romance" <?=(isset($_POST['genre']) && $_POST['genre'] == "Romance")? "selected = true" : "" ?>>Romance</option>
                <option value="Action" <?=(isset($_POST['genre']) && $_POST['genre'] == "Action")? "selected = true" : "" ?>>Action</option>
                <option value="Horror" <?=(isset($_POST['genre']) && $_POST['genre'] == "Horror")? "selected = true" : "" ?>>Horror</option>
                <option value="Mystery" <?=(isset($_POST['genre']) && $_POST['genre'] == "Mystery")? "selected = true" : "" ?>>Mystery</option>
            </select>

            <label for="format">Format</label>
            <select  id="format" name="format">
                <option value="">All</option>
                <option value="Hardbound" <?=(isset($_POST['format']) && $_POST['format'] == "Hardbound")? "selected = true" : "" ?>>Hardbound</option>
                <option value="Softbound" <?=(isset($_POST['format']) && $_POST['format'] == "Softbound")? "selected = true" : "" ?>>Softbound</option>
            </select>

            <br><br><div class="flex"><label for="agegroup">Age Group</label></div>
                    <input type="checkbox" name="agegroup[]" value="Kids" id="kids" <?= (in_array("Kids",$age_group))? "checked" : "" ?>>           
                    <label for="kids">Kids</label>
                    <input type="checkbox" name="agegroup[]" value="Teens" id="kids" <?= (in_array("Teens",$age_group))? "checked" : "" ?>>           
                    <label for="kids">Teens</label>
                    <input type="checkbox" name="agegroup[]" value="Adults" id="kids" <?= (in_array("Adults",$age_group))? "checked" : "" ?>>           
                    <label for="kids">Adults</label>
              

            <br><br><label for="searchbard">SEARCH</label>
            <input type="text" name="searchbar" value="<?= $keyword ?>">
            <input type="submit" name="search">

        </form>

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
                    
                    <td>
                        <a href="edit.php?id=<?= $arr['book_id']?>" class="edit">edit</a>
                        <a data-id="<?= $arr['book_id']?>" data-title="<?= $arr['book_title']?>" class="edit del">delete</a>
                    </td>
                    
                </tr>

            <?php
                $counter++;
                }
            ?>
    </table>
    
<script src="book.js"></script>
</body>

</html>