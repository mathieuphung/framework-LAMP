# framework-LAMP
---

## Create new route in config/routing.php
`$router->get('/YourURL', 'YourControllerPrefix#YourMethodSuffixedByAction');`

`$router->post('/YourURL', 'YourControllerPrefix#YourMethodSuffixedByAction');`

---

## Using Twig
```
$twig = new \Config\Twig('home/index.html.twig');
$twig->render(
    array
    (
    )
);
```

---

## Using the ORM

### SELECT(data, table1, joinFactor = null, table2 = null, $whereParam = null, $whereValue = null, orderBy = null)

```
$response = $connexion->select('*','users', null, null, null, null);
if(!empty($response)) {
    var_dump($response);
    Log::access();
}
else {
    Log::error();
    die("Requete invalide");
}
```
### WHERE

```
$response = $connexion->select('*','users', null, null, 'id', 8);
if(!empty($response)) {
    // do some action here
    Log::access();
}
else {
    Log::error();
    die("Requete invalide");
}
```
### UPDATE($table, array $column, array $data, $whereParam, $whereValue)

```
$connexion->update('users', ['username'], ['rrecezc'], 'id', '8');
```

### COUNT

```
$count = $connexion->count('users');
if(!empty($count)) {
    // do some action here
    Log::access();
}
else {
    Log::error();
    die("Requete invalide");
}
```

### EXIST

```
$exist = $connexion->exist('users', 'id', 9);
if(!empty($exist)) {
    // do some action here
    Log::access();
}
else {
    Log::error();
    die("Requete invalide");
}
```
### DELETE

```
$delete = $connexion->delete('users', 'id', 56);
```

### PERSIST

```
$user = new YourEntity();
$user->getWithId(10);
$user->setParam1('yolo');
$user->setParam2('tonton');
$connexion->persist($user);
```
