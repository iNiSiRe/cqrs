
    public function __construct(RouterInterface $router)
    {
        parent::__construct();
        $this->router = $router;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $routes = $this->router->getRouteCollection();

        $generator = new DocGenerator();

        foreach ($routes->getIterator() as $name => $route) {
            foreach ($route->getMethods() as $method) {
                /**
                 * @var RPC $schema
                 */
                $schema = unserialize($route->getDefault('_schema'));

                if (!$schema) {
                    continue;
                }

                $generator->addPath($method, $route->getPath(), $schema->input, $schema->output, $schema->tags, $schema->description);
            }
        }

        $content = json_encode($generator->getDoc(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents('swagger.json', $content);

        echo $content . PHP_EOL;

        return Command::SUCCESS;
    }
}