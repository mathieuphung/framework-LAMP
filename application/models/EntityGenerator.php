<?php
function do_tabs($tabs)
{
    $ret = '';
    for ($i=0; $i <= $tabs; $i++) {
        $ret .= ' ';
        return $ret;
    }
}
$host = $argv[1];
$db = $argv[2];
$user = $argv[3];
$password= $argv[4];
$tableName = $argv[5];
$className = $argv[6];
// Do some magic here
$tabs = 4;
$code = "<?php\n\n";
$code .= "namespace App\\Entities;\n\n";
$code .= "class " .  ucfirst($className). "Entity extends \\App\\Models\\Model\\QueryBuilder\n{\n";
function select($host, $db, $user, $password, $tableName) {
    $query = "SHOW columns FROM $tableName";
    $response = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
    $prepare = $response->prepare($query);
    $prepare->execute();
    $data = $prepare->fetchAll();
    return $data;
}
$fields = select($host, $db, $user, $password, $tableName);
$code .= do_tabs($tabs) . 'protected $columns = [';
foreach ($fields as $field)
{
    $code .="'".  $field['Field']."', ";
}
$code .= do_tabs($tabs) . "];\n";
$code .= do_tabs($tabs) . "public \$infos = [];\n";
$code .= do_tabs($tabs) . "public \$table = '$argv[5]';\n";
$code .= do_tabs($tabs) . "private \$connexion = null;\n";
foreach ($fields as $field)
{
    $code .= do_tabs($tabs) . 'public $'.$field['Field'].";\n";
}
$code .= "\n";
$code .= do_tabs($tabs) . "public function __construct()\n";
$code .= do_tabs($tabs) . "{\n";
$code .= do_tabs($tabs) . "\$this->connexion = new \\PDO('mysql:host=$host;dbname=$db', '$user', '$password');
        \$this->connexion->query(\"SET NAMES utf-8;\");\n";
$code .= do_tabs($tabs) . "}\n\n";
foreach ($fields as $field)
{
    $code .= do_tabs($tabs) . 'public function get'.ucfirst($field['Field'])."()\n";
    $code .= do_tabs($tabs) . "{\n";
    $code .= do_tabs($tabs+2) . 'return $this->'.$field['Field'].";\n";
    $code .= do_tabs($tabs) . "}\n\n";
    $code .= do_tabs($tabs) . 'public function set'.ucfirst($field['Field']).'($'.$field['Field'].")\n";
    $code .= do_tabs($tabs) . "{\n";
    $code .= do_tabs($tabs+2) . '$this->'.$field['Field'].' = $'.$field['Field'].";\n";
    $code .= do_tabs($tabs) . "}\n\n";
}
$code .= do_tabs($tabs) . "public function getAll()\n";
$code .= do_tabs($tabs) . "{\n";
$code .= do_tabs($tabs) . "\$data = [];\n";
foreach ($fields as $field)
{
    $code .= do_tabs($tabs) . "\$data[] = \$this->" . $field['Field'] . ";\n";
}
$code .= do_tabs($tabs) . "return \$this->infos = \$data;\n";
$code .= do_tabs($tabs) . "}\n\n";

$code .= do_tabs($tabs) . "public function getWithId(\$id)\n";
$code .= do_tabs($tabs) . "{\n";
$code .= do_tabs($tabs) . "\$exist = parent::exist(\$this->table, 'id', \$id);\n";
$code .= do_tabs($tabs) . "if(\$exist === true)\n";
$code .= do_tabs($tabs) . "{\n";
$code .= do_tabs($tabs) . "\$data = parent::getById(\$this->table, \$id);\n";
foreach ($fields as $field)
{
    $code .= do_tabs($tabs) . '$this->'.$field['Field']." = \$data[0]['".$field['Field']."'];\n";
}
$code .= do_tabs($tabs) . "return true;\n";
$code .= do_tabs($tabs) . "}\n";
$code .= do_tabs($tabs) . "else {\n";
$code .= do_tabs($tabs) . "return false;\n";
$code .= do_tabs($tabs) . "}\n";
$code .= do_tabs($tabs) . "}\n\n";
$code .= "}\n";
file_put_contents('../Entities/' . ucfirst($className) . 'Entity.php', $code);