<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tanner G - Assignment 7</title>

        <link rel="stylesheet" href="mainStyleSheet.css">
        <script src="main.js"></script>
    </head>
    <body>
        <h1>Dogs Available for Adoption</h1>

        <button id="GetButton">Get Data</button>
        <br>
        <button id="AddButton">Add</button>
        <button id="DeleteButton" disabled>Delete</button>
        <button id="UpdateButton" disabled>Update</button>

        <div id="AddUpdatePanel">

            <div>
                <div class="formLabel">Dog ID</div><input id="dogIDInput" type="number">
            </div>
            <div>
                <div class="formLabel">Dog Name</div><input id="dogNameInput" type="text">
            </div>
            <div>
                <div class="formLabel">Dog Age</div><input id="dogAgeInput" type="number">
            </div>
            <div>
                <div class="formLabel">Dog Breed</div><input id="dogBreedInput" type="text">
            </div>
            <div>
                <div class="formLabel">Trained</div><input id="trainedInput" type="checkbox">
            </div>
            <div>
                <button id="DoneButton">Done</button>
                <button id="CancelButton">Cancel</button>
            </div>
        </div>

        <table>
            <tr>
                <th>Dog ID</th>
                <th>Dog Name</th>
                <th>Dog Age</th>
                <th>Dog Breed</th>
                <th>Trained?</th>
            </tr>
        </table>

    </body>
</html>
