<?php
namespace LSP;

use Orlex\ContainerAwareTrait;

class RepositoryManager {
    use ContainerAwareTrait;

    const repos_namespace = "\\LSP\\Repository\\";

    protected $cache = [];

    public function factory($class) {
        if (substr($class, 0, 1) != '\\') {
            $class = $this::repos_namespace . $class;
        }

        if (!isset($this->cache[$class])) {
            $this->cache[$class] = $repo = new $class();

            if ($this->getContainer() && method_exists($repo, 'setContainer'))
                $repo->setContainer($this->getContainer());
        }

        return $this->cache[$class];
    }

    public function allReportRepositories() {
        $repos = [];

        $dir = new \FilesystemIterator(join(DIRECTORY_SEPARATOR, [dirname(__FILE__), 'Repository', 'Report']));
        foreach ($dir as $fileinfo) {
            $network = rtrim($fileinfo->getFilename(), '.php');
            $class = $this::repos_namespace . 'Report\\' . $network;
            if (class_exists($class, true)) {
                $repos[$network] = $this->factory($class);
            }
        }
        return $repos;
    }

    public function repository($class) {
        return $this->factory($class);
    }
}