# orchid-rocont

для использования команд необходимо добавить в app/Console/Kernel.php:

    if (file_exists($directory = app_path() . '/Orchid/Console/Commands')) {
        $this->load($directory);
    }
