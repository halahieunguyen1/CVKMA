#include<stdio.h> // define the header file
#include <math.h>
int main()   // define the main function  
{  
    long long n;
    scanf("%lld", &n);
    long long m = 9;
    short k = 1;
    while (n > m * k) {
        n = n - m * k;
        k++;
        m *= 10;
    }
    long long index = pow(10, k - 1 -(n + 1) % k);
    n = m / 9 + (n - 1) / k;
    printf("%lld", (n / index) % 10);  // print the statement.  
    return 0;
}  