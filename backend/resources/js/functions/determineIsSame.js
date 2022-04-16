export const determineIsSame = (inputtedTagName, tags) => {
  // 入力したタグと同じ名前のタグが存在するかどうかを返す
  return tags.find((item) => item.name === inputtedTagName);
};
