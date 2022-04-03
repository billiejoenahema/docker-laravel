import { MAX_LENGTH } from '../consts/maxLength';

export const determineIsOver = (length) => {
  if (MAX_LENGTH.content - 10 < length && length <= MAX_LENGTH.content) {
    return 'warn';
  } else if (MAX_LENGTH.content < length) {
    return 'error';
  } else {
    return '';
  }
};
