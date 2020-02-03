##
## EPITECH PROJECT, 2019
## graphic
## File description:
## Makefile
##

SRC_DIR	=	./src/

SRC	=	$(SRC_DIR)OpenFile.cpp	\
		$(SRC_DIR)Poll.cpp	\
		$(SRC_DIR)SFML.cpp	\
		$(SRC_DIR)Explode.cpp 	\
		$(SRC_DIR)Calculs.cpp	\
		main.cpp

OBJ	=	$(SRC:.cpp=.o)

INC_DIR	=	./include/

CXXFLAGS=	-W -Wall -Wextra -I$(INC_DIR)

NAME	=	209poll

all:	$(OBJ)
	@g++ -o $(NAME) $(OBJ) $(CXXFLAGS) -lsfml-graphics -lsfml-window -lsfml-system

clean:
	@rm -f $(OBJ)

fclean:	clean
	@rm -f $(NAME)

re:	fclean all

.PHONY: all clean fclean re