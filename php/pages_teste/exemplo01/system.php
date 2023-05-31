<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle Interno</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Sistema de Controle Interno</h1>
        <nav>
            <ul>
                <li><a href="#">Página Inicial</a></li>
                <li><a href="#">Cadastro de Clientes</a></li>
                <li><a href="#">Ordens de Serviço</a></li>
                <li><a href="#">Histórico de Reparos</a></li>
                <li><a href="#">Relatórios</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Painel de Visão Geral</h2>
            <div class="stats">
                <div class="stat-card">
                    <h3>Ordens de Serviço em Andamento</h3>
                    <p>25</p>
                </div>
                <div class="stat-card">
                    <h3>Dispositivos em Reparo</h3>
                    <p>15</p>
                </div>
                <div class="stat-card">
                    <h3>Serviços Concluídos</h3>
                    <p>100</p>
                </div>
            </div>
        </section>

        <section>
            <h2>Cadastro de Clientes</h2>
            <form>
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" required>

                <button type="submit">Cadastrar Cliente</button>
            </form>

            <h3>Lista de Clientes</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>(99) 99999-9999</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td>(88) 88888-8888</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Outras seções, como Ordem de Serviço, Histórico de Reparos e Relatórios -->
    </main>

    <footer>
        <p>&copy; 2023 Empresa de Conserto de Computadores e Notebooks</p>
    </footer>
</body>

</html>
