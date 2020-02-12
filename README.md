# Image service
This is a simple service for proxying external images for the purpose of subsequent optimization or conversion.

## Resize image
The service allows you to change the aspect ratio of the image by transferring the mode and size
```curl
http://example.com/?image={imageURL}&mode=resize&width=150&height=150
```

Parameters width or height optional.

## Crop image
 The service allows you to crop the image indicating the aspect ratio of the image
 ```curl
 http://example.com/?image={imageURL}&mode=crop&width=150&height=150
 ```
 
 Parameters width or height optional.
 
 ## Optimization image
 Thanks to the package spatie/image-optimizer the service optimizes the image size with minimal loss of quality
```curl
 http://example.com/?image={imageURL}&optimize
 ```

## Convert image to webp
Thanks to the package rosell-dk/webp-convert, the service has the ability to convert the image to webp format
```curl
 http://example.com/?image={imageURL}&webp
 ```

## Using
All query parameters can be used both together and optionally.

The service performs actions on the image sequentially, the strategy for working with the image is determined by a set of specified parameters and request add-ons.

## Security
The service provides simple protection against unauthorized use.

To be able to download images from a remote server, you must register the domain in the list of allowed in the file security.php

## Fast Start
The service has a simple configuration for quick deployment. To work you need a docker, docker-compose
```bash
docker-compose up -d
```
*Service will be launched by default on port 8080
