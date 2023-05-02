{
  description = "OAuth2 for Chatwork API";

  outputs = { self, nixpkgs }:
    let
      pkgs = nixpkgs.legacyPackages.aarch64-darwin;
      shellnix = import ./shell.nix { inherit pkgs; };
    in {
      packages.aarch64-darwin.default = pkgs.php82;
      packages.aarch64-darwin.devShells.default = shellnix;
    };
}
