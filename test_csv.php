<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Upload File Here </h2>

        
        <a href="" id="downloadLogs" class="text-warning d-none" target="_blank">Download Log Here</a>
       <br>

        <div id="errorMessages" class="alert alert-danger d-none"></div>

        <div id="successMessages" class="alert alert-success d-none"></div>

        <form id="submitCsvForm" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="csv_file" class="form-label">File</label>
                <input type="file" class="form-control" id="csv_file" name="csv_file" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
            
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#submitCsvForm').on('submit', function(e) {
                e.preventDefault();
                let csv_file = document.querySelector("#csv_file")
                if (csv_file) {

                    var formData = new FormData();
                    formData.append("csv_file", csv_file.files[0])

                    $.ajax({
                        url: 'upload.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if(response){

                                // response=JSON.parse(response);
                               
                                if (response.status=="error" || response.status=="errors") {
                                   
                                    // $('#errorMessages').removeClass('d-none').html(response.message.join('<br>'));
                                    $('#successMessages').addClass('d-none');

                                    $('#downloadLogs').removeClass('d-none').attr('href', response.error_file);
                                } else {
                                   
                                   
                                    // $('#errorMessages').addClass('d-none');
                                    $('#successMessages').removeClass('d-none').html(response.message.join('<br>'));
                                    $('#csv_file').val('');
                                    
                                    setTimeout(() => {
                                        $('#successMessages').addClass('d-none');
                                    }, 8000);
                                }

                            }else{
                                $('#errorMessages').removeClass('d-none').text('An error occurred while uploading the file.');
                            }
                        },
                        error: function() {
                            $('#errorMessages').removeClass('d-none').text('An error occurred while uploading the file.');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>