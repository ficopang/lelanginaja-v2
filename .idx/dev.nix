{pkgs}: {
  channel = "stable-23.11";
  packages = [
    pkgs.nodejs_20
    pkgs.php83
    pkgs.php83Packages.composer
  ];
  idx.extensions = [
    "amiralizadeh9480.laravel-extra-intellisense"
    "bmewburn.vscode-intelephense-client"
    "codingyu.laravel-goto-view"
    "esbenp.prettier-vscode"
    "formulahendry.auto-close-tag"
    "MehediDracula.php-namespace-resolver"
    "mikestead.dotenv"
    "mohamedbenhida.laravel-intellisense"
    "MrChetan.goto-laravel-components"
    "MrChetan.laravel-goto-config"
    "onecentlin.laravel-blade"
    "onecentlin.laravel5-snippets"
    "shufo.vscode-blade-formatter"
    "stef-k.laravel-goto-controller"
    "svelte.svelte-vscode"
    "usernamehw.errorlens"
    "Vue.volar"
  ];
  idx.previews = {
    enable = true;
    previews = {
      web = {
        command = [
          # "php" "artisan" "serve" "--port" "$PORT" "--host" "0.0.0.0"
          "npm" "run" "dev" "--" "--port" "$PORT" "--host" "0.0.0.0"
        ];
        manager = "web";
      };
    };
  };
}