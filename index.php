<?php
require_once 'config.php';
$movies = $conn->query(query:"SELECT * FROM movies ORDER BY Title");
$movieArray = array();
while($movie = $movies->fetch_assoc()){
    array_push($movieArray, $movie);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <title>TP1</title>
</head>
<body>
    <div class="container">
        <div class="col-md-6 m-auto mt-5">
            <div class="input-group">
                <input type="search" class="form-control" id="searchInput">
                <button class="btn btn-success" id="searchBtn">Search</button>
            </div>
            <select name="select" id="formselect" multiple class="form-select d-none">

            </select>
        </div>
        <div class="col-md-8 m-auto">
            <div class="row">
                <div class="col-md-3 m-auto text-center">
                <button class="btn btn-primary" id="prevBtn" class="prev" alt="">Prev</button>
                </div>
                <div class="col-md-6 mt-5">
                    <div class="card">
                        <div class="card-body m-auto">
                            <img src="" alt="" class="img-fluid" id="img">
                        </div>
                        <div class="card-footer">
                            <p>Movie Title: <strong><span id="title"></span></strong></p>
                            <p>Genre: <strong><span id="genre"></span></strong></p>
                            <p>Director/s: <strong><span id="director"></span></strong></p>
                            <p>Actors: <strong><span id="actor"></span></strong></p>
                            <p>Awards: <strong><span id="award"></span></strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 m-auto text-center">
                    <button class="btn btn-primary" id="nextBtn" class="next" alt="">Next</button>
                </div>
            </div>
        </div>
    </div>
    <script src="jquery-3.6.1.js"></script>
    <script>
        $(document).ready(function(){
            let movieArr = <?php echo json_encode($movieArray)?>;
            let pointer = 0;
            
            showUi(pointer);
            $('#nextBtn').click(function(){
                pointer++;
                if(pointer == movieArr.length){
                    pointer = 0;
                }
                showUi(pointer);
            })
            $('#prevBtn').click(function(){
                pointer--;
                if(pointer < 0){
                    pointer = movieArr.length - 1;
                }
                showUi(pointer);
            })
            
            $('prevBtn').click(function(){
                pointer--;
                if(pointer < 0){
                    pointer = movieArr.length - 1;
                }
                showUi(pointer);
            })

            $('#searchInput').keyup(function(){
                let value = $ ('#searchInput').val();
                let tittleArr = [];
                if (value.length == 0) {
                    $('#formselect') .addClass('d-none');
                    return;
                }
                movieArr.forEach(function(movie, index){
                    if (movie.Title.toUpperCase().startsWith(value.toUpperCase())) {
                        tittleArr.push([movie.Title, index]);
                    }
                })
                if (tittleArr.length == 0) {
                    $('#formselect') .addClass('d-none');
                    return;
                }
                let option = "";
                tittleArr.forEach(function(movie) {
                    option += `<option value='${movie[1]}'>${movie[0]}</option>`;
                })

                $('#formselect').html(option) .removeClass('d-none');

            })

            $('#formselect').change(function() {
                let value = this.value;

                pointer = value;
                $('#formselect').addClass('d-none');
                $('#searchInput').val(movieArr[pointer].Title);
                $('#searchBtn').click(function() {
                    $('#searchInput').val('');
                
                    showUi(pointer);    
                })
            })

            function showUi(pointer){
                $('#img').attr("src","images/" + movieArr[pointer].imdbID + ".jpg" );
                $('#title').html(movieArr[pointer].Title);
                $('#genre').html(movieArr[pointer].Genre);
                $('#director').html(movieArr[pointer].Director);
                $('#actor').html(movieArr[pointer].Actors);
                $('#award').html(movieArr[pointer].Awards);
            }

        })
    </script>
</body>
</html>