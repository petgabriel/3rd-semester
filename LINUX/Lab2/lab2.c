#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <unistd.h>

#define BUFSIZE 256

void suffix(char* c, long int* num)
{
	long int multiplier = 1;

	if( !strcmp("B", c) )
		multiplier = 1;
		
	if( !strcmp("b", c) )
		multiplier = 512;

	if( !strcmp("h", c) )
		multiplier = 10;
	
	if( !strcmp("k", c) )
		multiplier = 1000;
	
	if( !strcmp("K", c) )
		multiplier = 1 << 10;
	
	if( !strcmp("Ki", c) )
		multiplier = 1 << 10;
	
	if( !strcmp("M", c) )
	
		multiplier = 1000000;
	
	if( !strcmp("Mi", c) )
		multiplier = 1 << 20;
	

	*num = (*num ) * multiplier;
}

int main(int argc, char* argv[])
{
	int opt;
	int main_flags = 0;
	int fd_output;
	int fd_input;
	long int bytes;
	long int where;
	long int resize;
	int s_flag = 0, p_flag = 0, t_flag = 0;

	char* pEnd1;
	char* pEnd2;
	char* pEnd3;
	char* in_path = (char*)calloc(BUFSIZE, sizeof(char));
	char* out_path = (char*)calloc(BUFSIZE, sizeof(char));

	while( ( opt = getopt( argc, argv, "i:o:n:p:t:s" ) ) != -1 )
	{
		switch(opt)
		{
			case 'i':
				strcpy(in_path, optarg);
				
				if( access( in_path, F_OK ) == -1 )
				{
					printf("Input file doesn't exist!\n");
					return -1;
				}
				
				else
				{
					fd_input = open(in_path, O_RDONLY, 0777);
				}	

				main_flags++;
				break;
			case 'o':
				strcpy( out_path, optarg );
				
				if( access( out_path, F_OK ) == -1 )
				{
					fd_output = open(out_path, O_WRONLY | O_CREAT, 0777);
				}

				else
				{
					fd_output = open(out_path, O_WRONLY, 0777);
				}

				main_flags++;
				break;
			case 'n':
				main_flags++;
				bytes = strtol(optarg, &pEnd1, 10);
				suffix(pEnd1, &bytes);
				printf("%ld\n", bytes);
				break;
			case 'p':
				p_flag = 1;
				where = strtol(optarg, &pEnd2, 10);
				suffix(pEnd2, &where);
				printf("%ld\n", where);
				break;
			case 't':
				t_flag = 1;
				resize = strtol(optarg, &pEnd3, 10);
				suffix(pEnd3, &resize);
				printf("%ld\n", resize);
				break;
			case 's':
				s_flag = 1;
				break;
		}
	}

	if( main_flags != 3 )
	{
		printf("You didn't pass all mandatory arguments to script!\n");
		return -1;

	}

	if( !s_flag )
	{
		close(fd_output);
		fd_output = open(out_path, O_WRONLY | O_TRUNC, 0777);	
	}

	else
	{
		lseek(fd_output, 0, SEEK_SET);
	}

	if( p_flag )
	{
		lseek(fd_output, where, SEEK_SET);
	} 

	char* buf = (char*)calloc(BUFSIZE + 10, sizeof(char));

	int tmp_size = bytes;

	while( tmp_size > 0 )
	{
		if(read(fd_input, &buf, bytes)==-1)
		{
			printf("Error reading from file!\n");
			return -1;
		}

		if(write(fd_output, &buf, bytes)==-1)
		{
			printf("Error writing to file!\n");
			return -1;
		}

		tmp_size -= bytes;
	}

	if(t_flag)
	{
		ftruncate(fd_output, resize);	
	}

	close(fd_input);
	close(fd_output);

	return 0;
}
