{ pkgs ? import <nixpkgs> { } }:

# @see https://github.com/NixOS/nixpkgs/blob/22.05/pkgs/build-support/mkshell/default.nix
pkgs.mkShell {
  # a list of packages to add to the shell environment
  packages = let
    php = (pkgs.php82.buildEnv {
      extensions = ({ enabled, all }: enabled ++ (with all; [
        xdebug
      ]));
      extraConfig = ''
        xdebug.mode=debug
      '';
    });
    in [php pkgs.php82Packages.composer];
  # propagate all the inputs from the given derivations
  inputsFrom = [];
  # support mkDerivation attrs
}
