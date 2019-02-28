<?php
/**
    @SWG\Tag(
        name="auth",
        description="auth",
        @SWG\ExternalDocumentation(
            description="Find out more about our store",
            url="http://swagger.io"
        )
    )
 */

/**
     @SWG\Post(path="/auth/join",
         tags={"auth"},
         summary="record create",
         description="Record create: actionCreate CREATE Post /users",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "record content",
            required = true,
            type = "string",
            @SWG\Schema(ref = "#/definitions/User")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )

     @SWG\Post(path="/auth/login",
         tags={"auth"},
         summary="record create",
         description="Record create: actionCreate CREATE Post /users",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "query",
            name = "username",
            description = "username",
            required = true,
            type = "string",
            default = "test",
         ),
         @SWG\Parameter(
            in = "query",
            name = "password",
            description = "password",
            required = true,
            type = "string",
            default = "123456",
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )

     @SWG\Get(path="/auth/info",
         tags={"auth"},
         summary="auth info",
         description="Auth info",
         produces={"application/json"},
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
 */