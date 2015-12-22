<?php
    namespace imgetter;
    use DOMDocument;
    use Exception;

    class ImException extends Exception {

    }

    // We create this class to process our url to get images from it
    class imgetter{

        private $url;

        function __construct($url){
            $this->url = $url;
        }
        // This function gonna watch our images links array and save
        // content to the local storage 
        private function saveImages($array, $directory, $success) {

            $url = array_pop($array);
            $file_name = explode('/', $url);
            $count = count($file_name);
            $img = $file_name[--$count];
            $img_format = explode('.', $img);
            $img_format = array_pop($img_format);
            $content;

            // watch if our url is valid and throw exceptions if it's not
            try {

                $headers = @get_headers( $url );
                // print_r($headers);
                if ($headers[11] == 'HTTP/1.1 404 Not Found'){
                    throw new ImException( $url.' HTTP/1.1 404 Not Found' );
                }
                elseif( $headers[0] == 'HTTP/1.1 301 Moved Permanently' ){
                    throw new ImException( 'HTTP/1.1 301 Moved Permanently' );
                }
                elseif( $headers[0] == 'HTTP/1.1 403 Forbidden' ){
                    throw new ImException('HTTP/1.1 403 Forbidden');
                }
                elseif (!empty($url)){
                    $content = file_get_contents($url);
                }
                                    
            }
            catch (ImException $a){
                // here we decide what to do with Exceptions
                print $a->getMessage();
            }

            // Check if image format is valid
            if ( $img_format === 'gif' || $img_format === 'jpg' || $img_format === 'png'){

                $destination = $directory.'/'.$img;
                $saved = array_push($success,  $destination);

                // save our image
                if ( file_put_contents($destination, $content ) && count($array) >= 1 ){                         
                    $this->saveImages($array, $directory, $success);
                }
                                    
            }
            else {
                if ( count($array) >= 1 ){
                    $this->saveImages($array, $directory, $success);

                }
            }

            // return list of successfuly loaded images
            if(count($array) == 0){
                    print json_encode($success);
            }
        }

        public function getUrl(){
            try {

                $url = $this->url;

                // Checking if url is correct
                if ( preg_match('~(https://|http://)~', $url) ){

                    // getting domain name
                    $url_parts = explode('/', $url);
                    $domain = implode('/', [$url_parts[0] ,$url_parts[1] ,$url_parts[2]]);
                    $directory = 'extracted_images/'.$url_parts[2];

                        // create our object with Dom structure and handle errors
                        libxml_use_internal_errors(true);
                        $page = new DOMDocument();
                        $page->loadHTMLFile($url);

                        foreach (libxml_get_errors() as $error) {
                                // do something with errors
                        }

                    // here we get all elements with img tag
                    $elements = $page->getElementsByTagName('img');

                    // push all img links into array
                    $links = [];
                    $success = [];
                    foreach ( $elements as $element ) {

                        $src = $element->getAttribute('src');

                        // watch if link is local
                        if ( preg_match( '~(https://|http://)~', $src )){
                            array_push($links, $src);
                        }
                       elseif( preg_match( '~(//www)~', $src ) ){
                            $src = 'http://'.substr($src, 2);
                            array_push($links, $src);
                        }
                       elseif( preg_match( '~(www)~', $src ) ){
                            $src = 'http://'.$src;
                            array_push($links, $src);
                        }
                        elseif( preg_match( '~(//)~', $src ) ){
                            $src = 'http://'.substr($src, 2);
                            array_push($links, $src);
                        }
                        else {
                            $src = $domain.$src;
                            array_push($links, $src);
                        }

                    }

                    // create new folder for domain
                    if (is_dir($directory) === false){

                        if (mkdir($directory, 0700)){
                            $new_directory = $directory;
                        }
                        else {
                                                
                        }

                    }

                    $this->saveImages($links, $directory, $success);
                }
                else{
                    throw new ImException( 'Insert correct value: "It must start from http:// or https://"' );
                }
            }
            catch (ImException $a){
                print $a->getMessage();
            }
        }
    }

    $imgSaver = new imgetter($_POST['url']);
    $imgSaver->getUrl();