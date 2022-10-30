<?php

namespace markhuot\craftpest\traits;

use markhuot\craftpest\base\Benchmark as BaseBenchmark;
use yii\debug\Module;

trait Benchmark
{
    /**
     * You can start a benchmark at any time. It does not have to come first in your
     * test.
     */
    function beginBenchmark()
    {
        // It would be nice to conditionally enable the debug bar when this is called
        // but theres a lot of setup in \craft\web\Application::bootstrapDebug() that
        // we don't want to take ownership of right now.
        // \Craft::$app->db->enableLogging = true;
        // \Craft::$app->db->enableProfiling = true;
        // \Craft::createObject(['class' => 'yiisoft\\debug\\Module']);
        
        // Because we can't dynamically load the debug bar we'll require DEV_MODE be
        // enabled by the user if they get here.
        if (!\Craft::$app->config->getGeneral()->devMode) {
            throw new \Exception('You must enable devMode to use benchmarking.');
        }

        // Normally each request bootstraps its own logTarget with a unique tag each
        // time. However, because we're running multiple requests through a single
        // logTarget we need to manually update thentag (triggering independant log)
        // files to be written.
        \craft\debug\Module::getInstance()->logTarget->tag = uniqid();

        return $this;
    }

    /**
     * Ending a benchmark returns a testable Benchmark class
     */
    function endBenchmark()
    {
        \craft\debug\Module::getInstance()->logTarget->export();
        
        return new BaseBenchmark();
    }

    function tearDownBenchmark()
    {
        $this->endBenchmark();
    }
}
