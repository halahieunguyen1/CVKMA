#include<stdio.h> // define the header file
#include <math.h>
#include <stdbool.h>
int main()   // define the main function  
{  
    long n, i, a = 0, c = 0, d = 0;
    bool b = false;
    int k;
    scanf("%ld", &n);
    for (i = 0; i < n; i++) {
        scanf("%d", &k);
        switch (k) {
            case 1:
                if (c > 0) {
                    c--;
                    d++;
                }
                else if (c == 0) {
                    a++;
                }
                break;
            case 2:
                if (b) {
                    d++;
                }
                b = !b;
                break;
            case 3:
             if (a > 0) {
                    a--;
                    d++;
                }
                else if (a == 0) {
                    c++;
                }
                break;
            default:
                d++;
                break;
        }
    }
    printf("%ld", c > 0 ? d + b + c : d + (b > 0 ? ((c +2) % 4 ? (c + 2) / 4 + 1 : (c + 2) / 4) : (c % 4 ? c / 4 + 1: c / 4)));  // print the statement.  
    return 0;
}  