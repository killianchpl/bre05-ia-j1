trait Debug {
    public
    function print(): void {
        // ici on récupère toutes les méthodes d'une classe
        $methods = get_class_methods($this);

        // je parcours toutes les méthodes
        foreach($methods as $method) {
            // je vérifie si le nom de la méthode contient le mot get
            if (str_contains($method, "get")) {
                // j'echo le retour de la méthode
                echo $this - > $method().
                "<br>";
            }
        }
    }
}

class Test {

    // j'utilise mon trait
    use Debug;

    public
    function __construct(private string $firstName, private string $lastName) {

    }

    public
    function getFirstName(): string {
        return $this - > firstName;
    }

    public
    function setFirstName(string $firstName): void {
        $this - > firstName = $firstName;
    }

    public
    function getLastName(): string {
        return $this - > lastName;
    }

    public
    function setLastName(string $lastName): void {
        $this - > lastName = $lastName;
    }
}


