<?
class Favorites{
  private $plugins = [];

  function __construct(){
      $directory = new RecursiveDirectoryIterator('plugins');
      $iterator = new RecursiveIteratorIterator($directory);
      foreach ($iterator as $info) {
          $path_name = $info->getPathname();
          if (preg_match('/.class.php$/', $path_name)){
              require_once $path_name;
          }
      }

      $this->findPlugins();
  }
	
  private function findPlugins() {
      $declared_classes = get_declared_classes();
      foreach ($declared_classes as $class){
        $ref_class = new ReflectionClass($class);
        if ($ref_class->implementsInterface('IPlugin')){
            array_push($this->plugins, $ref_class);
        }
      }
  }
	
  function getFavorites($methodName) {
    $list = [];
    foreach ($this->plugins as $plugin) {
        if ($plugin->hasMethod($methodName)){
            $class_name = $plugin->getName();
            $method = new ReflectionMethod($class_name, $methodName);
            if ($method->isAbstract()){
                $result = $method->invoke(null);
            }
            else {
                $result = $method->invoke(new $class_name);
            };

            $list[$class_name::getName()] = $result;
        }
    }
    return $list;
  }
}
