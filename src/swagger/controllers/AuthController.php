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
    @SWG\Definition(
        definition="Auth",
        required={"username","password"},

        @SWG\Property(
            property="username",
            type="string",
            description="username",
            example="admin"
        ),
        @SWG\Property(
            property="password",
            type="string",
            description="password",
            example="123456"
        ),
    )
 */

/**
     @SWG\Post(path="/auth/join",
         tags={"auth"},
         summary="auth join",
         description="Auth join: Post /auth/join",
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
         summary="auth login",
         description="Auth login: Post /auth/loin",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "record content",
            required = true,
            type = "string",
            @SWG\Schema(ref = "#/definitions/Auth")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )

     @SWG\Get(path="/auth/info",
         tags={"auth"},
         summary="auth info",
         description="Auth info: Get /auth/info",
         produces={"application/json"},
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
 */