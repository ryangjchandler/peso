# Peso

Peso is a Brainf*ck-inspired language that uses various tokens and sigils found in PHP as part of its syntax.

## Installation

```sh
composer global require ryangjchandler/peso
```

## Usage

Peso provides a command-line interpreter that can execute Peso scripts.

```sh
peso path/to/script.peso
```

Peso will read input from `STDIN` i.e. piping input in from the terminal.

```
echo 12 | peso path/to/script.peso
```

If you want to use the fast compiler, pass the `--compile` flag.

```
peso path/to/script.peso --compile
```

## Explanation

I built Peso as part of a blog post on writing an esoteric language in PHP. If you want to learn more, you can [read the post here](https://ryangjchandler.co.uk/posts/lets-write-an-esolang-in-php).