<?php

/**
 * Class View
 * The part that handles all the output
 */
class View
{
     public function render($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';
        require Config::get('PATH_VIEW') . $filename . '.php';
        require Config::get('PATH_VIEW') . '_templates/footer.php';
    }

    /**
     * Same like render(), but does not include header and footer
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     * @param mixed $data Data to be used in the view
     */
     public function renderPage($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . $filename . '.php';
    }
	
	/*
	 * render with sidebar, that shows sold, bought etc
	*/
	
	public function renderSidebar($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';
		require Config::get('PATH_VIEW') . '_templates/usersidebar.php';
        require Config::get('PATH_VIEW') . $filename . '.php';
        require Config::get('PATH_VIEW') . '_templates/footer.php';
    }
    
	
	 public function renderAdmin($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';
        require Config::get('PATH_VIEW') . '_templates/admin/sidebar.php';
        require Config::get('PATH_VIEW') . $filename . '.php';
    }
}
?>