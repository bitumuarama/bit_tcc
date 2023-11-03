<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: rgba(5, 0, 0, 0.5);
        }
    </style>
</head>

<body>

    <form class="grid-template" method="post">
        <div class="normal-text">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
        </div>

        <div class="normal-text">
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>
        </div>
        <div class="normal-text">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" required>
        </div>
        <div class="small-text">
            <label for="txtexpequeno">Texto Exemplo Pequeno:</label>
            <input type="text" name="txtexpequeno" required>
        </div>
        <div class="larger-text">
            <label for="txtexgrande">Texto Exemplo Grande:</label>
            <input type="text" name="txtexgrande" required>
        </div>
        <div>
            <button type="submit">Cadastrar</button>
        </div>
    </form>


</body>

</html>