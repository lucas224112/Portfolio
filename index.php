<?php
    $dbhost = "🤫";
    $dbuser = "🤫";
    $dbpass = "🤫";
    $dbname = "🤫";

    // Conexão com o banco de dados
    $connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Verifica a conexão
    if ($connect->connect_error) {
        die("Não foi possível conectar ao banco de dados: " . $connect->connect_error);
    }

    $v1 = 0;

    // Verifica se os campos foram enviados via POST
    if (isset($_POST['Name'], $_POST['Email'], $_POST['Message'], $_POST['agreement'])) {
        $Name = trim($_POST['Name']);
        $Email = trim($_POST['Email']);
        $Message = trim($_POST['Message']);

        // Verifica se todos os campos foram preenchidos
        if (empty($Name) || empty($Email) || empty($Message)) {
            echo "Por favor, preencha todos os campos.";
            $v1 = 1;
        }

        // Obtém as palavras proibidas do banco de dados
        $palavrasProibidas = [];
        $query = "SELECT word FROM blocked_words";
        if ($result = $connect->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $palavrasProibidas[] = $row['word'];
            }
            $result->free();
        }

        // Verifica se o email contém palavras proibidas
        foreach ($palavrasProibidas as $palavra) {
            if (stripos($Email, $palavra) !== false) {
                echo "O email contém palavras não permitidas.";
                $v1 = 2;
            }
        }

        // Se nenhum erro foi encontrado até aqui
        if ($v1 == 0) {
            // Validação de formato do email
            if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                // Extrair o domínio do email
                $domain = substr(strrchr($Email, "@"), 1);
            
                // Verificar se o domínio possui registros MX
                if (checkdnsrr($domain, "MX")) {
                    echo "O email é válido e o domínio existe.";
                } else {
                    echo "O domínio do email não existe ou não está configurado para receber emails.";
                    $v1 = 3;
                }
            } else {
                echo "O formato do email é inválido.";
                $v1 = 3;
            }
        }

        // Obtém o IP do usuário
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        // Obtém detalhes de localização via API
        $token = '🤫';
        $url = "https://ipinfo.io/{$ip}?token={$token}";
        $json = file_get_contents($url);
        $details = json_decode($json, true);

        $city = $details['city'] ?? 'Desconhecido';
        $region = $details['region'] ?? 'Desconhecido';
        $country = $details['country'] ?? 'Desconhecido';

        // Se não houver erros, insere os dados no banco de dados
        if ($v1 == 0) {
            $stmt = $connect->prepare("INSERT INTO `contact` (`Name`, `Email`, `Message`, `Country`, `IP`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $Name, $Email, $Message, $country, $ip);
            $stmt->execute();
            $stmt->close();
        }

        // Redireciona o usuário com o código de verificação
        header("Location: ?v=$v1#ContactForm");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Permissions-Policy" content="interest-cohort=()">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lucas Guimaraes</title>
    <link rel="shortcut icon" href="https://monumentalgames.com.br/media/images/profires/bdlr0y4b8g9w98kf5l0g3p9z.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://assets.monumentalgames.com.br/css/scrollbar.css">
</head>
<body>
    <main class="background">
        <div class="banner b2">
            <div class="b2 _subclass">
                <div>
                    <img src="https://monumentalgames.com.br/media/images/profires/c14jxy9l1vkqo87tvu8et08f.png" alt="">
                </div>
                <div class="d1">
                    <h1>Lucas Guimarães</h1>
                    <p>Developer Python, C++</p>
                    <div class="_h563">
                        <a href="https://linkedin.com/in/lucas-guimar%C3%A3es-889159266/" target='_blank' rel='external'>
                            <svg src="https://lucasguimaraes.pro/svg/linkedin.svg" width="20px" height="20px"></svg>
                        </a>
                        <a href="https://github.com/lucas224112" target='_blank' rel='external'>
                            <svg src="https://lucasguimaraes.pro/svg/github.svg" width="20px" height="20px"></svg>
                        </a>
                        <a href="https://instagram.com/lucas224112" target='_blank' rel='external'>
                            <svg src="https://lucasguimaraes.pro/svg/instagram.svg" width="20px" height="20px"></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="about _flex_column_xCenter">
            <div class="_subclass">
                <h4>Sobre Mim</h4>
                <div class="about_description b2">
                    <div class="_ab82">
                        <p>Meu nome é Lucas Guimarães e sou um desenvolvedor de jogos apaixonado por tecnologia. Com habilidades avançadas em Python e conhecimento intermediário em C, C++ e JavaScript, atualmente estou criando uma biblioteca de interface gráfica em Python com foco no desenvolvimento de jogos.</p>
                    </div>
                </div>
                <div class="timeline b2 _t03">
                    <div class="_t02">
                        <div class="b2">
                            <div class="bb9"></div>
                            <div class="bb8"></div>
                        </div>
                        <div class="_t04">
                            <h4>2018-2020</h4>
                            <p>Dando meus primeiros passos no mundo da programação, me aprofundando em Python e no uso de decnologias como Blender e Photoshop para criaçao de jogos.</p>
                        </div>
                    </div>
                    <div class="_t02">
                        <div class="b2">
                            <div class="bb9"></div>
                            <div class="bb8"></div>
                        </div>
                        <div class="_t04">
                            <h4>2021</h4>
                            <p>Dando inicio a projetos pessoais como <a href="https://libmge.org/" target='_blank' rel='external'>LibMGE</a> me aperfeiçoando cada vez mais em python alen de continuar aprendendo coisas novas como html, css, JavaScript e sql</p>
                        </div>
                    </div>
                    <div class="_t02">
                        <div class="b2">
                            <div class="bb9"></div>
                            <div class="bb8"></div>
                        </div>
                        <div class="_t04">
                            <h4>2022</h4>
                            <p>Continuando projetos pessoais me aperfeiçoando na criaçao de jogos alen de continuar aprendendo coisas novas como C/C++</p>
                        </div>
                    </div>
                    <div class="_t02">
                        <div class="b2">
                            <div class="bb9"></div>
                            <div class="bb8"></div>
                            <div class="bb7"></div>
                        </div>
                        <div class="_t04">
                            <h4>2023...</h4>
                            <p>Dando um 'restart' em todos os projetos para aprimorá-los e em breve lançá-los, principalmente <a href="https://libmge.org/" target='_blank' rel='external'>LibMGE</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="_flex_column_xCenter">
            <div class="_subclass">
                <h4>Projetos</h4>
                <div>
                    <nav class="projects">
                        <div class="project _flex_column_xCenter">
                            <div class="project_img">
                                <img src="https://libmge.org/media/imgs/LibMGE.png" alt="">
                            </div>
                            <div class="_subclass">
                                <h4>LibMGE</h4>
                                <div class="project_used_skills">
                                    <svg src="https://lucasguimaraes.pro/svg/python.svg" width="20px" height="20px"></svg>
                                </div>
                                <div>
                                    <p>A LibMGE é uma biblioteca de interface gráfica para o desenvolvimento de programas e jogos 2d em python</p>
                                </div>
                                <div class="project_links">
                                    <a href="https://github.com/MonumentalGames/LibMGE" target='_blank' rel='external'>
                                        <svg src="https://lucasguimaraes.pro/svg/github.svg" width="25px" height="25px"></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="button_d001">
                                <a href="https://libmge.org/" target='_blank' rel='external'><div class="_flex_center">Acessar</div></a>
                            </div>
                        </div>
                        <?php
                            //<div class="project _flex_column_xCenter">
                            //    <div class="project_img">
                            //        <img src="https://libmge.org/media/imgs/MGE_Banner2.png" alt="">
                            //    </div>
                            //    <div class="_subclass">
                            //        <h4>MGE</h4>
                            //        <div>
                            //            <p>A MGE é a LibMGE funcionando de forma gráfica com algumas funcoes alciliares assim se tornando uma engine para programas e jogos 2d</p>
                            //        </div>
                            //        <div class="project_links">
                            //            <a href="https://github.com/MonumentalGames/MGE" target='_blank' rel='external'>
                            //                <svg src="https://lucasguimaraes.pro/svg/github.svg" width="25px" height="25px"></svg>
                            //            </a>
                            //        </div>
                            //    </div>
                            //    <div class="button_d001">
                            //        <a href="https://libmge.org/" target='_blank' rel='external'><div class="_flex_center">Acessar</div></a>
                            //    </div>
                            //</div>
                        ?>
                        <div class="project _flex_column_xCenter">
                            <div class="project_img">
                                <img src="https://lucasguimaraes.pro/media/imgs/Portfolio.png" alt="">
                            </div>
                            <div class="_subclass">
                                <h4>Portfolio</h4>
                                <div class="project_used_skills">
                                    <svg src="https://lucasguimaraes.pro/svg/html5.svg" width="20px" height="20px"></svg>
                                    <svg src="https://lucasguimaraes.pro/svg/js.svg" width="20px" height="20px"></svg>
                                    <svg src="https://lucasguimaraes.pro/svg/php.svg" width="20px" height="20px"></svg>
                                </div>
                                <div>
                                    <p>Projeto criado para apresentar meus trabalhos e habilidades aos visitantes interessados em conhecer mais sobre mim.</p>
                                </div>
                                <div class="project_links">
                                    <a href="https://github.com/lucas224112/Portfolio" target='_blank' rel='external'>
                                        <svg src="https://lucasguimaraes.pro/svg/github.svg" width="25px" height="25px"></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="button_d001">
                                <a href="https://lucasguimaraes.pro/"  target='_blank' rel='external'><div class="_flex_center">Acessar</div></a>
                            </div>
                        </div>
                        <div class="project _flex_column_xCenter">
                            <div class="project_img">
                                <img src="https://lucasguimaraes.pro/media/imgs/SVGAutoLoader.png" alt="">
                            </div>
                            <div class="_subclass">
                                <h4>SVGAutoLoader</h4>
                                <div class="project_used_skills">
                                    <svg src="https://lucasguimaraes.pro/svg/js.svg" width="20px" height="20px"></svg>
                                </div>
                                <div>
                                    <p>SVGAutoLoader é uma ferramenta leve que carrega automaticamente arquivos SVG em elementos &lt;svg&gt; usando o atributo src. Ele também detecta dinamicamente alterações e novos elementos SVG.</p>
                                </div>
                                <div class="project_links">
                                    <a href="https://github.com/lucas224112/SVGAutoLoader" target='_blank' rel='external'>
                                        <svg src="https://lucasguimaraes.pro/svg/github.svg" width="25px" height="25px"></svg>
                                    </a>
                                </div>
                            </div>
                            <div class="button_d001">
                                <a href="https://assets.lucasguimaraes.pro/js/SVGAutoLoader.js" target='_blank' rel='external'><div class="_flex_center">Acessar</div></a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <section class="_flex_column_xCenter">
            <div class="_subclass">
                <h4>Habilidades</h4>
                <div>
                    <nav class="skills">
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/python.svg" width="100px" height="100px"></svg>
                                    <h4>Python</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades avançadas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/cpp.svg" width="100px" height="100px"></svg>
                                    <h4>C/C++</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades intermediárias</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/html5.svg" width="100px" height="100px"></svg>
                                    <h4>Html/Css</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades intermediárias</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/js.svg" width="100px" height="100px"></svg>
                                    <h4>JavaScript</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades intermediárias</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/php.svg" width="100px" height="100px"></svg>
                                    <h4>PHP</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades intermediárias</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="skill">
                            <div style="width: 100%; height: 100%;">
                                <div class="skill_banner _flex_center">
                                    <svg src="https://lucasguimaraes.pro/svg/java.svg" width="100px" height="100px"></svg>
                                    <h4>Java</h4>
                                </div>
                                <div style="width: 100%; height: 35px;" class="_flex_column_xCenter">
                                    <div>
                                        <p>Habilidades basicas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <section class="_flex_column_xCenter">
            <div class="_subclass">
                <h4>Contato</h4>
                <div>
                    <nav class="_flex_center">
                        <form class="contact_send_mail _flex_center" id="ContactForm" method="POST">
                            <div class="in_contact_send_mail">
                                <div>
                                    <h4>Contate Me</h4>
                                </div>
                                <div>
                                    <div class="NameMail _flex_center">
                                        <input aria-invalid="true" autocomplete="name" id="name" name="Name" type="text" placeholder="Name" value="<?php if(isset($_POST['Name'])) {echo $_POST['Name'];} ?>" required>
                                        <div style="width: 20px;"></div>
                                        <input autocomplete="email" type="email" id="email" name="Email" placeholder="Email" data-min-length="2" required>
                                    </div>
                                    <div class="message _flex_center">
                                        <textarea autocomplete="message" type="message" id="message" name="Message" placeholder="Sua mensagem..." cols="30" rows="10" required></textarea>
                                    </div>
                                    <div class="contact_terms">
                                        <input type="checkbox" name="agreement" id="agreement" required>
                                        <label for="agreement" id="agreement-label">Eu li e aceito os <a href="https://lucasguimaraes.pro/terms" onclick="return Popup(this.href);">termos de uso</a></label>
                                    </div>

                                    <?php
                                        if (isset($_GET['v'])) {
                                            if ($_GET['v'] == "0") {
                                                echo "<div class='contact_error _flex_center'>";
                                                echo "    <svg src='https://lucasguimaraes.pro/svg/error.svg' width='25px' height='25px'></svg>";
                                                echo "    <p>Fomulario eviado com sucesso.</p>";
                                                echo "</div>";
                                            } else {
                                                echo "<div class='contact_error _flex_center'>";
                                                echo "    <svg src='https://lucasguimaraes.pro/svg/error.svg' width='25px' height='25px'></svg>";

                                                if ($_GET['v'] == "1") {
                                                    echo "    <p>Por favor, preencha todos os campos com dados validos.</p>";
                                                } else if ($_GET['v'] == "2") {
                                                    echo "    <p>O email contém palavras não permitidas.</p>";
                                                } else if ($_GET['v'] == "3") {
                                                    echo "    <p>Por favor, preencha com um email valido.</p>";
                                                }
                                                echo "</div>";
                                            }
                                            echo "<script>";
                                            echo "    let currentUrl = new URL(window.location.href);";
                                            echo "    if (currentUrl.searchParams.has('v')) {";
                                            echo "        currentUrl.searchParams.delete('v');";
                                            echo "        window.history.replaceState({}, document.title, currentUrl.toString());";
                                            echo "    }";
                                            echo "</script>";
                                        }
                                    ?>

                                    <div class="contact_send_button">
                                        <input id="btn-submit" type="submit" value="Enviar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </nav>
                    <nav class="contacts">
                        <div class="contact">
                            <div class="contact_banner _flex_center">
                                <a class="contact_banner _flex_center" href="mailto:commercial@lucasguimaraes.pro">
                                    <svg src="https://lucasguimaraes.pro/svg/email.svg" width="40px" height="40px"></svg>
                                    <h4>Email</h4>
                                </a>
                            </div>
                        </div>

                        <div class="contact">
                            <div class="contact_banner _flex_center">
                                <a class="contact_banner _flex_center" href="https://linkedin.com/in/lucas-guimar%C3%A3es-889159266/">
                                    <svg src="https://lucasguimaraes.pro/svg/linkedin.svg" width="30px" height="30px"></svg>   
                                    <h4>Linkedin</h4>
                                </a>
                            </div>
                        </div>

                        <div class="contact">
                            <div class="contact_banner _flex_center">
                                <a class="contact_banner _flex_center" href="https://github.com/lucas224112">
                                    <svg src="https://lucasguimaraes.pro/svg/github.svg" width="30px" height="30px"></svg>
                                    <h4>Github</h4>
                                </a>
                            </div>
                        </div>

                        <div class="contact">
                            <div class="contact_banner _flex_center">
                                <a class="contact_banner _flex_center" href="https://links.lucasguimaraes.pro">
                                    <h4>Links...</h4>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <footer>
            <a id="admin_link" href="https://admin.lucasguimaraes.pro/"></a>
            <div class='copyright _flex_center'>
                <p>© 2024 Lucas Guimarães</p>
            </div>
        </footer>
    </main>
    <script src="https://lucasguimaraes.pro/js/portfolio.js"></script>
    <script src="https://assets.lucasguimaraes.pro/js/SVGAutoLoader.js"></script>
</body>
</html>