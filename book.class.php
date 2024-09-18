<?php

    //Include the database.php so that we can access the class we make
    require_once "database.php";
    //this class will  will handle the operation in products

        class Book{

            public $id = "";
            public $barcode = "";
            public $title = "";
            public $author="";
            public $genre ="";
            public $publisher="";
            public $publication_date="";
            public $edition="";
            public $copies="";
            public $format="";
            public $age_group="";
            public $rating="";
            public $description="";

            protected $db;

            //this is a constructor every time an instance is created the code inside is called
            function __construct(){
                $this->db = new Database(); // instanciate a class Database
            }

            //this function will add a new product to the database
            function add(){
                //add a sql query to add in database
                $addquery = "INSERT INTO books (barcode,book_title,  book_author,  book_genre, book_publisher, publication_date, 
                                    book_edition,  book_copies, book_format, age_group, book_rating, book_description) 
                                    VALUES (:barcode,:title, :author, :genre, :publisher, :publication_date, :edition, :copies, :format, :age_group, :rating, :description);";

                //prepare the addquery to execution
                $prepquery = $this->db->connect()->prepare($addquery);

                //after preparing the query its time to add value in placeholder using bindparam
                $prepquery->bindParam(':barcode',$this->barcode);//first parameter is the placeholder, second parameter is where  get the value to pass on placeholder
                $prepquery->bindParam(':title',$this->title);
                $prepquery->bindParam(':author',$this->author);
                $prepquery->bindParam(':genre',$this->genre);
                $prepquery->bindParam(':publisher',$this->publisher);
                $prepquery->bindParam(':publication_date',$this->publication_date);
                $prepquery->bindParam(':edition',$this->edition);
                $prepquery->bindParam(':copies',$this->copies);
                $prepquery->bindParam(':format',$this->format);
                $prepquery->bindParam(':age_group',$this->age_group);
                $prepquery->bindParam(':rating',$this->rating);
                $prepquery->bindParam(':description',$this->description);


                //after binding the value execute the query
                if($prepquery->execute()){
                        return true;//return true if the execution is succesfull
                }else{
                        return false;       
                }

            }

            
            function update($book_id){//this function will handle the updating
                $edit_query = "UPDATE books SET barcode=:barcode,book_title= :title, book_author= :author,
                                        book_genre=:genre, book_publisher=:publisher, publication_date=:pub_date, book_edition=:edition,
                                        book_copies=:copies, book_format=:format, age_group=:group, book_rating=:rating,
                                         book_description=:description
                                        WHERE book_id=:id" ;
                
                $prepquery = $this->db->connect()->prepare($edit_query);

                //after preparing the query its time to add value in placeholder using bindparam
                
                $prepquery->bindParam(':id',$book_id);//important to use the id 
                $prepquery->bindParam(':barcode',$this->barcode);
                $prepquery->bindParam(':title',$this->title);
                $prepquery->bindParam(':author',$this->author);
                $prepquery->bindParam(':genre',$this->genre);
                $prepquery->bindParam(':publisher',$this->publisher);
                $prepquery->bindParam(':pub_date',$this->publication_date);
                $prepquery->bindParam(':edition',$this->edition);
                $prepquery->bindParam(':copies',$this->copies);
                $prepquery->bindParam(':format',$this->format);
                $prepquery->bindParam(':group',$this->age_group);
                $prepquery->bindParam(':rating',$this->rating);
                $prepquery->bindParam(':description',$this->description);

                if($prepquery->execute()){
                    return true;
                }
                else{
                    return false;
                }

            }

           

        function get_all_coloumn($keyword='', $genre='',$format='', $age_group=''){//this function will fetch all the coloumn
                //Write a query
                
                $array = (isset($age_group)?explode(',',$age_group) : []);
                
                //$array[0]=(isset($array[0])? $array[0] : "");
                //$array[1]=(isset($array[1])? $array[1] : "");
                //$array[2]=(isset($array[2])? $array[2] : "");
                $counter = 1;
                $keyholder=[];

                if($age_group != ""){
                    foreach($array as $ar){
                        $tmp = ":arr" . $counter;
                        $keyholder[] = $tmp;
                        $counter++;
                    }
                }

                $keys = implode( ' "%" ' , $keyholder);
                
                //echo $keys, ",,,";
                $choose = "SELECT * FROM books  WHERE  status = 1
                                AND (book_title LIKE '%' :keyword '%' OR  book_author )  
                                AND  (book_genre LIKE '%' :genre '%')
                                AND  (book_format LIKE '%' :format '%')
                                AND (age_group LIKE '%' $keys '%')
                                ORDER BY  book_title ASC;";
                //AND (age_group LIKE '%' :arr1 '%' :arr2 '%' :arr3 '%')
                //prepare the sql 
                $query = $this->db->connect()->prepare($choose);
                $query->bindParam(':keyword',$keyword);
                $query->bindParam(':genre',$genre);
                $query->bindParam(':format',$format);
                
                $counter = 0;
                foreach($keyholder as $keys){
                 //   echo $keys, $array[$counter], " /";
                    $query->bindParam($keys, $array[$counter]);
                    $counter++;
                }

                //$query->bindParam(':arr1',$array[0]);
                //$query->bindParam(':arr2',$array[1]);
                //$query->bindParam(':arr3',$array[2]);
                //if the query is executed
                $data=null;
                if($query->execute()){
                        $data = $query->fetchAll();//assign the fetch data to $data
                        return $data? $data : [];//if $data is not empty return data else return empty array[]
                }

                return [];//if not executed return empty string
        }

        
        function delete($id){
            $query = "UPDATE books SET status=0 WHERE status = 1 AND book_id=:id ;";
            $prep_query = $this->db->connect()->prepare($query);
            $prep_query->bindParam(':id',$id);
            return $prep_query->execute();
        }

        function get_row($book_id){//This function will return a specific row based on the id
            $query = "SELECT * FROM books WHERE status = 1 AND book_id=:id;";
            $prep_query = $this->db->connect()->prepare($query);

            $prep_query->bindParam(':id',$book_id);

            if($prep_query->execute()){
                
                $data=$prep_query->fetch();

                return $data? $data : [];
            }
            return[];

        }


        function not_my_barcode($id, $barcode){//this function return true if the barcode is not the same in its own barcode
            $query = "SELECT barcode FROM books WHERE status = 1 AND book_id=:id;";
            $prep_query = $this->db->connect()->prepare($query);

            $prep_query->bindParam(':id',$id);

            if($prep_query->execute()){
                $data=$prep_query->fetch();
                
                if($data['barcode'] != $barcode  && $this->is_barcode_unique($barcode)){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
        
        function is_barcode_unique($barcode){//This function return true if it has  duplicate
            $query = "SELECT barcode FROM books WHERE status = 1 AND barcode=:barcode;";
            $prep_query = $this->db->connect()->prepare($query);

            $prep_query->bindParam(':barcode',$barcode);

            if($prep_query->execute()){
                
                $data=$prep_query->fetch();// fetching the array
                if($data)
                    return true;
                else
                    return false;
            }
        }

    }   
        //$obj = new Book();
     //   echo $obj->is_barcode_unique(1);
      //  echo $obj->not_my_barcode(25,2);
        //var_dump($obj-> get_all(18));
        //$array = $obj->get_all(18);
        //echo $array['book_title'];
        
        
