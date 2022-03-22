import { TYPING_MAP_TYPING_TEXT_END_CHAR } from "./util";
// コードから文字列取得
export function getChar(code) {
  switch (code) {
    case "KeyA":
      return "a";
    case "KeyB":
      return "b";
    case "KeyC":
      return "c";
    case "KeyD":
      return "d";
    case "KeyE":
      return "e";
    case "KeyF":
      return "f";
    case "KeyG":
      return "g";
    case "KeyH":
      return "h";
    case "KeyI":
      return "i";
    case "KeyJ":
      return "j";
    case "KeyK":
      return "k";
    case "KeyL":
      return "l";
    case "KeyM":
      return "m";
    case "KeyN":
      return "n";
    case "KeyO":
      return "o";
    case "KeyP":
      return "p";
    case "KeyQ":
      return "q";
    case "KeyR":
      return "r";
    case "KeyS":
      return "s";
    case "KeyT":
      return "t";
    case "KeyU":
      return "u";
    case "KeyV":
      return "v";
    case "KeyW":
      return "w";
    case "KeyX":
      return "x";
    case "KeyY":
      return "y";
    case "KeyZ":
      return "z";
    case "Digit0":
      return "0";
    case "Digit1":
      return "1";
    case "Digit2":
      return "2";
    case "Digit3":
      return "3";
    case "Digit4":
      return "4";
    case "Digit5":
      return "5";
    case "Digit6":
      return "6";
    case "Digit7":
      return "7";
    case "Digit8":
      return "8";
    case "Digit9":
      return "9";
    case "Comma":
      return ",";
    case "Period":
      return ".";
    case "Minus":
      return "-";
    default:
      return "";
  }
}

// 入力キー判定
export function checkInputKey(code, roman, romanIndex) {
  const inputChar = getChar(code);
  const currentChar = roman[romanIndex];
  const prevChar3 = romanIndex >= 3 ? roman[romanIndex - 3] : "";
  const prevChar2 = romanIndex >= 2 ? roman[romanIndex - 2] : "";
  const prevChar = romanIndex >= 1 ? roman[romanIndex - 1] : "";
  const nextChar = roman[romanIndex + 1];
  const nextChar2 = nextChar === TYPING_MAP_TYPING_TEXT_END_CHAR ? TYPING_MAP_TYPING_TEXT_END_CHAR : roman[romanIndex + 2];

  if (inputChar === "") {
    return 0;
  }

  if (inputChar === currentChar) {
    return 1;
  }

  //「い」の曖昧入力判定
  if (inputChar === 'y' && currentChar === 'i' && (prevChar === '' || prevChar === 'a' || prevChar === 'i' || prevChar === 'u' || prevChar === 'e' || prevChar === 'o')) {
    roman.splice(romanIndex, 0, 'y');
    return 2;
  }

  if (inputChar === 'y' && currentChar === 'i' && prevChar === 'n' && prevChar2 === 'n' && prevChar3 !== 'n') {
    roman.splice(romanIndex, 0, 'y');
    return 2;
  }

  if (inputChar === 'y' && currentChar === 'i' && prevChar === 'n' && prevChar2 === 'x') {
    roman.splice(romanIndex, 0, 'y');
    return 2;
  }

  //「う」の曖昧入力判定
  if (inputChar === 'w' && currentChar === 'u' && (prevChar === '' || prevChar === 'a' || prevChar === 'i' ||
    prevChar === 'u' || prevChar === 'e' || prevChar === 'o')) {
    roman.splice(romanIndex, 0, 'w');
    return 2;
  }

  if (inputChar === 'w' && currentChar === 'u' && prevChar === 'n' && prevChar2 === 'n' && prevChar3 !== 'n') {
    roman.splice(romanIndex, 0, 'w');
    return 2;
  }

  if (inputChar === 'w' && currentChar === 'u' && prevChar === 'n' && prevChar2 === 'x') {
    roman.splice(romanIndex, 0, 'w');
    return 2;
  }

  if (inputChar === 'h' && prevChar2 !== 't' && prevChar2 !== 'd' && prevChar === 'w' &&
    currentChar === 'u') {
    roman.splice(romanIndex, 0, 'h');
    return 2;
  }

  //「か」「く」「こ」の曖昧入力判定
  if (inputChar === 'c' && prevChar !== 'k' &&
    currentChar === 'k' && (nextChar === 'a' || nextChar === 'u' || nextChar === 'o')) {
    roman[romanIndex] = 'c';
    return 2;
  }

  //「く」の曖昧入力判定
  if (inputChar === 'q' && prevChar !== 'k' && currentChar === 'k' && nextChar === 'u') {
    roman[romanIndex] = 'q';
    return 2;
  }

  //「し」の曖昧入力判定
  if (inputChar === 'h' && prevChar === 's' && currentChar === 'i') {
    roman.splice(romanIndex, 0, 'h');
    return 2;
  }

  //「じ」の曖昧入力判定
  if (inputChar === 'j' && currentChar === 'z' && nextChar === 'i') {
    roman[romanIndex] = 'j';
    return 2;
  }

  //「しゃ」「しゅ」「しぇ」「しょ」の曖昧入力判定
  if (inputChar === 'h' && prevChar === 's' && currentChar === 'y') {
    roman[romanIndex] = 'h';
    return 2;
  }

  //「じゃ」「じゅ」「じぇ」「じょ」の曖昧入力判定
  if (inputChar === 'z' && prevChar !== 'j' && currentChar === 'j' &&
    (nextChar === 'a' || nextChar === 'u' || nextChar === 'e' || nextChar === 'o')) {
    roman[romanIndex] = 'z';
    roman.splice(romanIndex + 1, 0, 'y');
    return 2;
  }

  if (inputChar === 'j' && prevChar !== 'z' && currentChar === 'z' &&
    nextChar === 'y' && (nextChar2 === 'a' || nextChar2 === 'u' || nextChar2 === 'e' || nextChar2 === "o")) {
    roman[romanIndex] = 'j';
    roman.splice(romanIndex + 1, 1);
    return 2;
  }

  //「し」「せ」の曖昧入力判定
  if (inputChar === 'c' && prevChar !== 's' && currentChar === 's' &&
    (nextChar === 'i' || nextChar === 'e')) {
    roman[romanIndex] = 'c';
    return 2;
  }

  //「ち」の曖昧入力判定
  if (inputChar === 'c' && prevChar !== 't' && currentChar === 't' && nextChar === 'i') {
    roman[romanIndex] = 'c';
    roman.splice(romanIndex + 1, 0, 'h');
    return 2;
  }

  //「ちゃ」「ちゅ」「ちぇ」「ちょ」の曖昧入力判定
  if (inputChar === 'c' && prevChar !== 't' && currentChar === 't' && nextChar === 'y') {
    roman[romanIndex] = 'c';
    return 2;
  }

  //「cya」=>「cha」
  if (inputChar === 'h' && prevChar === 'c' && currentChar === 'y') {
    roman[romanIndex] = 'h';
    return 2;
  }

  //「つ」の曖昧入力判定
  if (inputChar === 's' && prevChar === 't' && currentChar === 'u') {
    roman.splice(romanIndex, 0, 's');
    return 2;
  }

  //「つぁ」「つぃ」「つぇ」「つぉ」の分解入力判定
  if (inputChar === 'u' && prevChar === 't' && currentChar === 's' &&
    (nextChar === 'a' || nextChar === 'i' || nextChar === 'e' || nextChar === 'o')) {
    roman[romanIndex] = 'u';
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  if (inputChar === 'u' && prevChar2 === 't' && prevChar === 's' &&
    (currentChar === 'a' || currentChar === 'i' || currentChar === 'e' || currentChar === 'o')) {
    roman.splice(romanIndex, 0, 'u');
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「てぃ」の分解入力判定
  if (inputChar === 'e' && prevChar === 't' && currentChar === 'h' && nextChar === 'i') {
    roman[romanIndex] = 'e';
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「でぃ」の分解入力判定
  if (inputChar === 'e' && prevChar === 'd' && currentChar === 'h' && nextChar === 'i') {
    roman[romanIndex] = 'e';
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「でゅ」の分解入力判定
  if (inputChar === 'e' && prevChar === 'd' && currentChar === 'h' && nextChar === 'u') {
    roman[romanIndex] = 'e';
    roman.splice(romanIndex + 1, 0, 'x');
    roman.splice(romanIndex + 2, 0, 'y');
    return 2;
  }

  //「とぅ」の分解入力判定
  if (inputChar === 'o' && prevChar === 't' && currentChar === 'w' && nextChar === 'u') {
    roman[romanIndex] = 'o';
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「どぅ」の分解入力判定
  if (inputChar === 'o' && prevChar === 'd' && currentChar === 'w' && nextChar === 'u') {
    roman[romanIndex] = 'o';
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「ふ」の曖昧入力判定
  if (inputChar === 'f' && currentChar === 'h' && nextChar === 'u') {
    roman[romanIndex] = 'f';
    return 2;
  }

  //「ふぁ」「ふぃ」「ふぇ」「ふぉ」の分解入力判定
  if (inputChar === 'w' && prevChar === 'f' &&
    (currentChar === 'a' || currentChar === 'i' || currentChar === 'e' || currentChar === 'o')) {
    roman.splice(romanIndex, 0, 'w');
    return 2;
  }

  if (inputChar === 'y' && prevChar === 'f' && (currentChar === 'i' || currentChar === 'e')) {
    roman.splice(romanIndex, 0, 'y');
    return 2;
  }

  if (inputChar === 'h' && prevChar !== 'f' && currentChar === 'f' &&
    (nextChar === 'a' || nextChar === 'i' || nextChar === 'e' || nextChar === 'o')) {

    roman[romanIndex] = 'h';
    roman.splice(romanIndex + 1, 0, 'u');
    roman.splice(romanIndex + 2, 0, 'x');
    return 2;
  }

  if (inputChar === 'u' && prevChar === 'f' &&
    (currentChar === 'a' || currentChar === 'i' || currentChar === 'e' || currentChar === 'o')) {
    roman.splice(romanIndex, 0, 'u');
    roman.splice(romanIndex + 1, 0, 'x');
    return 2;
  }

  //「ん」の曖昧入力判定（「n'」には未対応）
  if (inputChar === 'n' && prevChar2 !== 'n' && prevChar === 'n' && currentChar !== 'a' && currentChar !== 'i' &&
    currentChar !== 'u' && currentChar !== 'e' && currentChar !== 'o' && currentChar !== 'y') {
    roman.splice(romanIndex, 0, 'n');
    return 2;
  }

  if (inputChar === 'x' && prevChar !== 'n' && currentChar === 'n' && nextChar !== 'a' && nextChar !== 'i' &&
    nextChar !== 'u' && nextChar !== 'e' && nextChar !== 'o' && nextChar !== 'y') {
    if (nextChar === 'n') {
      roman[romanIndex] = 'x';
    }
    else {
      roman.splice(romanIndex, 0, 'x');
    }

    return 2;
  }

  //「きゃ」「にゃ」などを分解する
  if (inputChar === 'i' && currentChar === 'y' &&
    (prevChar === 'k' || prevChar === 's' || prevChar === 't' || prevChar === 'n' || prevChar === 'h' ||
      prevChar === 'm' || prevChar === 'r' || prevChar === 'g' || prevChar === 'z' || prevChar === 'd' ||
      prevChar === 'b' || prevChar === 'p') &&
    (nextChar === 'a' || nextChar === 'u' || nextChar === 'e' || nextChar === 'o')) {
    if (nextChar === 'e') {
      roman[romanIndex] = 'i';
      roman.splice(romanIndex + 1, 0, 'x');
    }
    else {
      roman.splice(romanIndex, 0, 'i');
      roman.splice(romanIndex + 1, 0, 'x');
    }

    return 2;
  }

  //「しゃ」「ちゃ」などを分解する
  if (inputChar === 'i' &&
    (currentChar === 'a' || currentChar === 'u' || currentChar === 'e' || currentChar === 'o') &&
    (prevChar2 === 's' || prevChar2 === 'c') && prevChar === 'h') {
    if (nextChar === 'e') {
      roman.splice(romanIndex, 0, 'i');
      roman.splice(romanIndex + 1, 0, 'x');
    }
    else {
      roman.splice(romanIndex, 'i');
      roman.splice(romanIndex + 1, 0, 'x');
      roman.splice(romanIndex + 2, 0, 'y');
    }

    return 2;
  }

  //「しゃ」を「c」で分解する
  if (inputChar === 'c' && currentChar === 's' && prevChar !== 's' && nextChar === 'y' &&
    (nextChar2 === 'a' || nextChar2 === 'u' || nextChar2 === 'e' || nextChar2 === 'o')) {
    if (nextChar2 === 'e') {
      roman[romanIndex] = 'c';
      roman[romanIndex + 1] = 'i';
      roman.splice(romanIndex + 1, 0, 'x');
    }
    else {
      roman[romanIndex] = 'c';
      roman.splice(romanIndex + 1, 0, 'i');
      roman.splice(romanIndex + 2, 0, 'x');
    }

    return 2;
  }

  //「っ」の分解入力判定
  if ((inputChar === 'x' || inputChar === 'l') &&
    (currentChar === 'k' && nextChar === 'k' || currentChar === 's' && nextChar === 's' ||
      currentChar === 't' && nextChar === 't' || currentChar === 'g' && nextChar === 'g' ||
      currentChar === 'z' && nextChar === 'z' || currentChar === 'j' && nextChar === 'j' ||
      currentChar === 'd' && nextChar === 'd' || currentChar === 'b' && nextChar === 'b' ||
      currentChar === 'p' && nextChar === 'p')) {
    roman[romanIndex] = inputChar;
    roman.splice(romanIndex + 1, 0, 't');
    roman.splice(romanIndex + 2, 0, 'u');
    return 2;
  }

  //「っか」「っく」「っこ」の特殊入力
  if (inputChar === 'c' && currentChar === 'k' && nextChar === 'k' &&
    (nextChar2 === 'a' || nextChar2 === 'u' || nextChar2 === 'o')) {
    roman[romanIndex] = 'c';
    roman[romanIndex + 1] = 'c';
    return 2;
  }

  //「っく」の特殊入力
  if (inputChar === 'q' && currentChar === 'k' && nextChar === 'k' && nextChar2 === 'u') {
    roman[romanIndex] = 'q';
    roman[romanIndex + 1] = 'q';
    return 2;
  }

  //「っし」「っせ」の特殊入力
  if (inputChar === 'c' && currentChar === 's' && nextChar === 's' &&
    (nextChar2 === 'i' || nextChar2 === 'e')) {
    roman[romanIndex] = 'c';
    roman[romanIndex + 1] = 'c';
    return 2;
  }

  //「っちゃ」「っちゅ」「っちぇ」「っちょ」の曖昧入力判定
  if (inputChar === 'c' && currentChar === 't' && nextChar === 't' && nextChar2 === 'y') {
    roman[romanIndex] = 'c';
    roman[romanIndex + 1] = 'c';
    return 2;
  }

  //「っち」の曖昧入力判定
  if (inputChar === 'c' && currentChar === 't' && nextChar === 't' && nextChar2 === 'i') {
    roman[romanIndex] = 'c';
    roman[romanIndex + 1] = 'c';
    roman.splice(romanIndex + 2, 0, 'h');
    return 2;
  }

  //「l」と「x」の完全互換性
  if (inputChar === 'x' && currentChar === 'l') {
    roman[romanIndex] = 'x';
    return 2;
  }

  if (inputChar === 'l' && currentChar === 'x') {
    roman[romanIndex] = 'l';
    return 2;
  }

  return 3;
}