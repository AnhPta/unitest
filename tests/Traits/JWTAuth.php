<?php

namespace Tests\Traits;

trait JWTAuth
{
    protected $headers = [];
    protected $xUser = [
        'id'                => 1,
        'name'              => 'SupperAdmin',
        'email'             => 'admin@nht.com',
        'phone'             => null,
        'status'            => 1,
        'status_txt'        => 'Kích hoạt',
        'email_verified_at' => null,
        'avatar'            => null,
        'avatar_path'       => 'data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAYAAAA8AXHiAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAIHklEQVR4nO3ca2xT9x3G8ceXJI7t2rmQOyQsIThsTQiXrKUpY1Ri0I2t7VpN07QbTENorbSbJiFW0W5lb6ZV29pOY4O1W1dpq5qtWwMFVDSaLGFQSkNaVJIAgSQOuSe2YzsXO\/ZeQDbGfE7i4F+SYz+fN0g5t3+Sb3zO+fsYXTgcBlGsGW\/+y7oopqbDwu7qYws5DoojBxq3Qb\/Qg6D4xLBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QYF3oAsZSSasCaTTkoLk9HocMGe2YKUq1GGJP0GPcF4fME0NflQ1ebB+0fuNBybghTwfCM+\/3ZkQdgTUuOuOw3e5vQVNcX1TgNRh1+VbdVcflPdpxCV5snqn0uNnERVqrViId3r8Q9W\/NhMkf+lqxpybCmJSOn0IKK6mwAwOT4FD48M4gzx6+juaEfoamZI6PZ0XxYjnUZ2PnUatgzU6LeNtlkQOWmHFRuyoFneAK\/+PZZXG\/3Cowy8Wg6rNLKdDz+03VINhnueF+hqTB6O3wxGBUBGr54N5kN+OYzlTGJCgAaap08FcaQZsP69I4VsGVEf\/qLZCoYwj\/\/3hWTfdENmj0VfnxLnuKyYCCEU0e6cfpoN4Z6xxAMhGCxJSG3yIqiMhvK78tCocP+n\/WbG\/rhHpyYj2EnDE2GlV9sRVqWSXH5wX3n0Vzf\/z9f87kD6O\/y4\/2GftQeuoy0rBRseLAAGz5TgLq\/dkoPOeFoMqyMHOWouq+M\/l9UkbgGJnD05XYcfbk9lkOjmzR5jWWxRZ6sBADPME9pi4Emw\/K6JhWXLSu1wZisyW8rrmjyNzDYO6a4zJqWjK\/tLYfeoJvHEdHtNBlWX4cPfZ3Kk5lVW\/Kw5+C9KKlIn8dR0a00GRYA1L+ufidX6LDjB7++B9\/5ZRUc6zLmaVQ0TZN3hQDwj9c6UPWpfCxfZVddr2x9JsrWZ6Kz1Y1jf2zHeyejexKB5kazr1jhMHDwyfMYVrneulWhw45d+9dg3yv3Y+3mHOHRkWbDAoCh3jE8+\/g7qtdbt8v\/iBW79q\/Bd5+vQvYys+DoEpumwwJuxLX\/64048eo1TAVDs97OsTYTe1+8D1Uqbw3R3Gk+LAAITIRQ81wLnv5SA04f6551YCazETv2VWDjQ0uFR5h44iKsaQPdfvz+mQ\/w5BfqcbKmA5PjUzNuo9fr8MXvfRRFZbZ5GGHiiKuwpo30jePVn1\/Enoffxpt\/uIJxf1B1fYNRj0efKJvTsXRz+Anq9PE\/eRuXYU3zjwbwxm8v4YeP1eHsWz2q665ck4El+akRl4VCyg8ApqRGP2OTatHsLM+sxXVY03zuAH73dDNqD11SXW+Fwkz9mFf5Fc82h2ft7UvUt5kYU3+F1YKECGvakZeuwHlZ+WNVGbmRX7FGR5SfmChcGf21WaFDfRuvKxD1PhebhAoLADouKodlMEa+9hnsUZ6E\/di9S5CUEt2Pcf0DylMc7qEJ+EcZ1oLY\/o0VKK2c2xvM6dnKDwl6hiM\/jnPxnSHFbUxmI7Z+uXjWxy+pSEdZVabi8svNI7Pe12KmyavIuzdkYfvOFei95kXjYSfOnuiBa2DmB\/xKKtJV35Dud0aewb9wegBTwRAMxsh\/hw9+tRgj\/eNorHWqHr+ozIZd+yuhV7krfPeE+k2GVmgyrGm5y6149IkyPPItBzpbPWg9N4SOFjecl0cxOjKJcV8QySYDcossWLs5F5sfK1KMwz8aQOu54YjLfO4ATh+9jurPRp5INRj1+Mqeu7HxoWU4c\/w6rl5wweueRDAQgvmuJBSU3IXVG7OxdnOualR9nT6cr4+PN8k1HdY0vV6H5avsMz7poObUm92qnyt849AlVG3JU\/0c452O4bXnLiIcJx9t1OQ1Vqy5BsZRe1B9KsI9OIGXfvy+6pzWnXjrT1dx4V+DIvteCAkfltc1iee\/fw4TYzO\/\/dNU14c\/P\/thzOOqe70Tf3mhNab7XGiaPBWGY3S+6Grz4MUfNaPn2uwfu6n\/Wxd6rnmx86nVqneYs+EfDaDmhRacOtx9R\/tZjHQ3f0nh3dXHFnoss2axJ+H+zy1D9fYCZC+1RL19v9OHkzWdeLumY87XNCazAZ94pBCf\/Hyh4sSqEq9rEo2HnTj+ytW4mLO63YHGbdoM61ZZBWasqsrE0lIbcossWJKXCpPFiGSTAeFQGGO+IPyeAHo7fOhs86Dl3SG0X3DF7Pg6HVBamYGS8jQUl6cjMy8VFlsSzFYj9AYdJsam4HVPot\/pR2erB23vDaOtaTiu\/wOSA43btHkqvNVAtx8D3f4FO344DLQ13YiF\/ivhL95JBsMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0QwLBLBsEgEwyIRDItEMCwSwbBIBMMiEQyLRDAsEsGwSATDIhEMi0TowuEwAIQXeiAUX\/4NRLIvKjftS84AAAAASUVORK5CYII=',
        'created_at'        => '2018-10-22 17:36:29',
        'created_at_format' => '22-10-2018 17:36:29'
    ];
    protected $xSecret = 'secret';

    protected function authWithSupperAdmin()
    {
        factory(\Darkness\SSOClient\Repositories\UserPermissions\UserPermission::class)->create([
            'user_id'     => $this->xUser['id'],
            'permissions' => ['admin.super-admin']
        ]);

        $this->auth();
    }

    protected function authWithAdminHasPermissions(array $permissions = [])
    {
        $permissions = array_merge(['admin.admin'], $permissions);

        factory(\Darkness\SSOClient\Repositories\UserPermissions\UserPermission::class)->create([
            'user_id'     => $this->xUser['id'],
            'permissions' => $permissions
        ]);

        $this->auth();
    }

    protected function authWithUserHasPermissions(array $user, array $permissions = [])
    {
        $permissions = array_merge(['admin.admin'], $permissions);

        factory(\Darkness\SSOClient\Repositories\UserPermissions\UserPermission::class)->create([
            'user_id'     => $this->xUser['id'],
            'permissions' => $permissions
        ]);

        $this->auth();
    }

    protected function auth()
    {
        $this->headers['Accept']        = 'application/json';
        $this->headers['Content-Type']  = 'application/json';
        $this->headers['X-SECRET']      = $this->xSecret;
        $this->headers['X-USER']        = base64_encode(json_encode($this->xUser, true));
    }
}
